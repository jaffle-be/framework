angular.module('blog.controllers', ['blog.models'])
    .controller('BlogCtrl', function (Blog) {

        this.rpp = 15;
        this.total = 0;
        this.posts = [];

        var me = this;

        this.setLocale = function (locale) {

            //unset the old one
            this.options.locales[this.options.locale].active = false;
            //set the new one and cache active one
            this.options.locales[locale].active = true;
            this.options.locale = locale;
        };

        this.activeTab = function (locale) {
            return this.locale == locale;
        };

        this.list = function (table) {

            var pagination = table.pagination;
            var page = Math.ceil(pagination.start / me.rpp) + 1;

            Blog.query({
                page: page
            }, function (response, callback) {
                me.total = response.total;
                me.posts = response.data;
                pagination.numberOfPages = response.last_page;
            });
        };
    })

    .controller('BlogDetailCtrl', function ($state, $scope, Blog, BlogService, BlogImageService, BlogTagService) {

        this.images = BlogImageService;
        this.posts = BlogService;
        this.tags = BlogTagService;

        var me = this,
            id = $state.params.postId;

        $scope.dropzone = this.images.uploader(function (file, image, xhr) {
            me.post.images.push(image);
            this.removeFile(file);
            $scope.$apply();
        });

        //need to adjust translations to an object
        //since it will not send the languages
        //if they are sent as an array
        this.handleTranslations = function (original) {
            var translations = {};

            for (var locale in this.options.locales)
            {
                if (original[locale])
                {
                    translations[locale] = original[locale];
                }
            }

            return translations;
        };

        this.load = function (id) {
            if (id)
            {
                this.post = this.posts.find(id, function (post) {
                    me.post = post;
                });
            }
            else
            {
                this.post = new Blog();
            }
        };

        this.save = function () {
            this.posts.save(this.post);
        };

        this.updateImage = function (img) {
            this.images.update(me.post, img, this.handleTranslations(img.translations));
        };

        this.deleteImage = function (id) {
            this.images.delete(me.post, id, function () {
                _.remove(me.post.images, function (value, index, array) {
                    return value.id == id;
                });
            })
        };


        this.updateTag = function (tag) {
            this.tags.update(me.post, tag, this.handleTranslations(tag.translations));
        };

        this.deleteTag = function (id) {

            this.tags.delete().success(function () {
                _.remove(me.post.tags, function (value, index, array) {
                    return value.id == id
                });
            });
        };

        this.searchTag = function (id) {
            BlogTag.query({
                postId: me.post.id,
                query: id
            });
        };

        this.addTag = function (id) {

        };

        this.load(id);
    });

angular.module('blog.services', ['blog.models'])

    .factory('BlogService', function (Blog, $state, $timeout) {

        function Service() {
            //when creating, it should get locked so it won't trigger another save, till we have the id back from the server.
            this.locked = false;
            this.timeout = false;

            var me = this;

            this.find = function (id, success) {
                //also pass through the locale parameter (not the UI locale, but the input locale for the post itself
                Blog.get({id: id}, success);
            };

            this.save = function (post) {

                if (this.locked)
                    return;

                if (!post.id)
                {
                    this.locked = true;

                    return post.$save(function (post) {
                    }).success(function () {
                        me.locked = false;
                        $state.go('admin.blog.post', {postId: post.id});
                    }).error(function () {
                        me.locked = false;
                    });
                }
                else
                {
                    if (this.timeout)
                    {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function () {
                        return post.$update();
                    }, 1500);
                }
            };
        }

        return new Service();
    })

    .factory('BlogTagService', function (BlogTag) {

        function Service() {

            this.update = function (post, tag, translations) {
                tag.postId = post.id;
                tag.translations = translations;
                tag = new BlogTag(tag);
                return tag.$update();
            };

            this.delete = function (post, tag) {
                return BlogTag.delete({
                    postId: post.id,
                    tagId: id
                });
            };

            this.search = function () {

            };

        }

        return new Service();

    })

    .factory('BlogImageService', function (BlogImage, $state) {
        function Service() {

            var id = $state.params.postId

            //image uploader
            this.uploader = function (success) {
                return {
                    options: {
                        url: 'api/admin/blog/' + id + '/image',
                        clickable: true,
                        maxFileSize: 10
                    },
                    handlers: {
                        success: success
                    }
                }
            };

            this.update = function (post, img, translations) {
                img.translations = translations;
                img.postId = post.id;

                image = new BlogImage(img);
                return image.$update();
            };

            this.delete = function (post, imageId, success) {
                return BlogImage.delete({
                    postId: post.id,
                    imageId: imageId
                }, success);
            };
        }

        return new Service();
    });


angular.module('blog.models', ['ngResource'])
    .factory('Blog', function ($resource) {
        return $resource('api/admin/blog/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            get: {
                method: 'GET'
            },
            update: {
                method: 'PUT'
            }
        });
    })
    .factory('BlogImage', function ($resource) {
        var placeholders = {
            imageId: '@id',
            postId: '@postId'
        };

        return $resource('api/admin/blog/:postId/image/:imageId', placeholders, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            }
        });
    })
    .factory('BlogTag', function ($resource) {

        var placeholders = {
            tagId: '@id',
            postId: '@postId'
        };

        return $resource('api/admin/blog/:postId/tag/:tagId', placeholders, {
            query: {isArray: false},
            update: {
                method: 'PUT'
            }
        });
    });

function config($stateProvider) {

    $stateProvider
        .state('admin.blog', {
            abstract: true,
            url: "/blog",
            template: '<ui-view/>'
        })
        .state('admin.blog.posts', {
            url: "/posts",
            templateUrl: "templates/admin/blog/overview"
        })
        .state('admin.blog.post', {
            url: '/post/:postId',
            templateUrl: "templates/admin/blog/detail"
        });
}


angular.module('blog', ['blog.controllers', 'blog.models', 'blog.services'])
    .config(config);