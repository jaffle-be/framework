angular.module('blog')
    .controller('BlogController', function ($scope, Blog, $timeout) {

        //start with true so we don't see the layout flash
        this.loading = true;
        this.rpp = 15;
        this.total = 0;
        this.posts = [];

        var me = this;

        this.changeTab = function (locale) {
            this.query = '';
            this.options.locales[this.options.locale].active = false;
            //set the new one and cache active one
            this.options.locales[locale].active = true;
            this.options.locale = locale;
        };

        this.activeTab = function (locale) {
            return this.locale == locale;
        };

        this.list = function (table) {
            me.table = table;
            me.loading = true;
            //cannot use this here
            var pagination = table.pagination;
            var page = Math.ceil(pagination.start / me.rpp) + 1;

            Blog.query({
                page: page,
                query: table.search.predicateObject ? table.search.predicateObject.query : '',
                locale: me.options.locale,
            }, function (response, callback) {
                me.total = response.total;
                me.posts = response.data;
                pagination.numberOfPages = response.last_page;
                me.loading = false;
            });
        };

        this.check = function ($event) {
            $event.stopPropagation();
            return false;
        }
    });
angular.module('blog')
    .controller('BlogDetailController', function ($state, $scope, $timeout, Blog, BlogService, BlogImageService, BlogTagService) {

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

            for (var locale in this.options.locales) {
                if (original[locale]) {
                    translations[locale] = original[locale];
                }
            }

            return translations;
        };

        this.load = function (id) {
            if (id) {
                this.post = this.posts.find(id, function (post) {
                    me.post = post;
                });
            }
            else {
                this.post = new Blog();
            }
        };

        this.save = function () {
            var me = this;
            me.drafting = true;
            this.posts.save(me.post);
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

            this.tags.delete(me.post, id, _.remove(me.post.tags, function (value, index, array) {
                return value.id == id
            }));
        };

        this.searchTag = function (value, locale) {
            return this.tags.search(me.post, locale, value).then(function (response) {
                return response.data;
            });
        };

        this.createTag = function () {
            this.tags.create(me.post, function (tag) {
                me.post.tags.push(tag);
                me.tags.input = '';
            });
        };

        this.addTag = function ($item, $model, $label) {
            this.tags.link(me.post, $item, function () {
                me.post.tags.push($item);
                me.tags.input = "";
            });
        };

        this.publish = function () {
            var me = this;
            this.posts.publish(this.post, function () {
                me.drafting = false;
            });
        };

        this.load(id);
    });