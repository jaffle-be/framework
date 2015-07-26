angular.module('media')
    .factory('ImageService', function (Image, $timeout, $state) {

        function Service() {

            var id = $state.params.postId;
            this.timeouts = [];

            //image uploader
            this.uploader = function (type, id, success) {
                return {
                    options: {
                        url: 'api/admin/media/image',
                        params: {
                            ownerType: type,
                            ownerId: id,
                        },
                        clickable: true,
                        maxFileSize: 10,
                    },
                    handlers: {
                        success: success,
                    }
                }
            };

            this.list = function(type, id, success)
            {
                return Image.list({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.update = function (type, id, img) {

                if (this.timeouts[img.id]) {
                    $timeout.cancel(this.timeouts[img.id]);
                }

                this.timeouts[img.id] = $timeout(function () {
                    return img.$update({
                        ownerId: id,
                        ownerType: type
                    });
                }, 400);
            };

            this.delete = function (type, id, img, success) {
                return img.$delete({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

        }

        return new Service();

    });