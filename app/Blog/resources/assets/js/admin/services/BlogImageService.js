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