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