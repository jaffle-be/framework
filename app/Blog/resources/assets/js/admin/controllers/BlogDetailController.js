angular.module('blog')
    .controller('BlogDetailController', function ($state, $scope, $timeout, Blog, BlogService, BlogImageService, BlogTagService, InputTranslationHandler) {

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
            this.images.update(me.post, img, InputTranslationHandler(this.options.locales, img.translations));
        };

        this.deleteImage = function (id) {
            this.images.delete(me.post, id, function () {
                _.remove(me.post.images, function (value, index, array) {
                    return value.id == id;
                });
            })
        };

        this.updateTag = function (tag) {
            this.tags.update(me.post, tag, InputTranslationHandler(this.options.locales, tag.translations));
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