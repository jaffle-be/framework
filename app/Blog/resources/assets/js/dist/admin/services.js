angular.module('blog')
    .factory('BlogImageService', function (BlogImage, $state, $timeout) {
        function Service() {

            var id = $state.params.postId
            this.timeouts = [];

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

                if (this.timeouts[img.id]) {
                    $timeout.cancel(this.timeouts[img.id]);
                }

                this.timeouts[img.id] = $timeout(function () {
                    img.translations = translations;
                    img.postId = post.id;

                    image = new BlogImage(img);
                    return image.$update();
                }, 400);
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
angular.module('blog')

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

                if (!post.id) {
                    this.locked = true;

                    return post.$save(function () {
                        me.locked = false;
                        $state.go('admin.blog.post', {postId: post.id});
                    });
                }
                else {
                    if (this.timeout) {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function () {
                        return post.$update();
                    }, 400);
                }
            };
        }

        return new Service();
    });
angular.module('blog')
    .factory('BlogTagService', function (BlogTag, $timeout) {

        function Service() {

            this.searching = false;
            this.input = '';
            this.timeouts = [];

            var me = this;

            this.update = function (post, tag, translations) {

                if (this.timeouts[tag.id]) {
                    $timeout.cancel(this.timeouts[tag.id]);
                }

                this.timeouts[tag.id] = $timeout(function () {
                    tag.postId = post.id;
                    tag.translations = translations;
                    tag = new BlogTag(tag);
                    return tag.$update();
                }, 400);
            };

            this.create = function (post, locale, success) {
                tag = new BlogTag({
                    postId: post.id,
                    locale: locale,
                    name: me.input
                });

                tag.$save();
            };

            this.link = function (post, tag, success) {
                tag = new BlogTag(tag);
                tag.$update({
                    postId: post.id,
                    tagId: tag.id
                }, success);
            };

            this.delete = function (post, tag, success, error) {
                return BlogTag.delete({
                    postId: post.id,
                    tagId: tag
                }, success, error);
            };

            this.search = function (post, locale, value) {

                return BlogTag.query({
                    postId: post.id,
                    value: value,
                    locale: locale
                }).$promise;
            };

        }

        return new Service();

    })