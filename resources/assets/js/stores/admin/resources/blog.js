angular.module('blog.controllers', ['blog.factories', 'system'])
    .controller('BlogCtrl', function ($http, $state, blog, system) {

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

            blog.query({
                page: page
            }, function (response, callback) {
                me.total = response.total;
                me.posts = response.data;
                pagination.numberOfPages = response.last_page;
            });
        };
    })

    .controller('BlogDetailCtrl', function ($state, blog, $scope, $resource) {

        //when creating, it should get locked so it won't trigger another save, till we have the id back from the server.
        this.locked = false;

        var me = this,
            id = $state.params.postId;

        //image uploader
        $scope.dropzone = {
            options: {
                url: 'api/admin/blog/' + id + '/image',
                clickable: true,
                maxFileSize: 10
            },
            handlers: {
                success: function (file, image, xhr) {
                    me.post.images.push(image);
                    this.removeFile(file);
                    $scope.$apply();
                }
            }
        };

        this.load = function (id) {
            //also pass through the locale parameter (not the UI locale, but the input locale for the post itself
            blog.get({id: id}, function (post) {
                me.post = post;
            });
        };

        function unlock() {
            return setTimeout(function () {
                me.locked = false;
            }, 3000);
        }

        this.save = function () {

            if (!this.locked)
            {
                if (!this.post.id)
                {
                    this.post.$save(function (post) {
                        $state.go('admin.post', {postId: post.id});
                    });
                }
                else
                {
                    this.locked = true;

                    this.post.$update(function () {
                        unlock();
                    });
                }
            }
        };

        this.deleteImage = function (id) {

            image = $resource('api/admin/blog/:postId/image/:imageId', {
                postId: me.postId,
                imageId: '@id'
            }, {
                update:{
                    method: 'PUT'
                }
            });

            image.delete({
                postId: me.post.id,
                imageId: id
            }, function()
            {
                _.remove(me.post.images, function(value, index, array){
                    return value.id == id;
                });
            });
        };

        //init with the post or an empty one
        id ? this.load(id) : this.post = new blog();
    });

angular.module('blog.factories', ['ngResource'])
    .factory('blog', function ($resource) {
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
    });

function config($stateProvider) {

    $stateProvider
        .state('admin.blog', {
            url: "/blog",
            templateUrl: "templates/admin/blog/overview"
        })
        .state('admin.post', {
            url: '/post/:postId',
            templateUrl: "templates/admin/blog/detail"
        });
}


angular.module('blog', ['blog.controllers', 'blog.factories'])
    .config(config);