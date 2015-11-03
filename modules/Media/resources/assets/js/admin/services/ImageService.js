(function () {
    'use strict';

    angular.module('media')
        .factory('ImageService', function (Image, $timeout, $state, $http) {

            function Service() {

                var id = $state.params.postId;
                this.timeouts = [];

                //image uploader
                this.uploader = function (type, id, limit, handlers, ownerIdCallback) {

                    if (typeof handlers === 'function')
                    {
                        //handlers is only a success callback
                        handlers = {
                            success: handlers
                        };
                    }

                    var config = {
                        options: {
                            url: 'api/admin/media/image',
                            params: {
                                ownerType: type,
                                ownerId: id,
                            },
                            clickable: true,
                            maxFileSize: 10,
                            init: function () {
                                this.on('maxfilesexceeded', function (file) {
                                    this.removeFile(file);
                                });
                            }
                        },
                        handlers: handlers,
                    };

                    if (limit)
                    {
                        config.options.maxFiles = limit;
                    }

                    return config;
                };

                this.list = function (type, id, success) {
                    return Image.list({
                        ownerId: id,
                        ownerType: type
                    }, success);
                };

                this.update = function (type, id, img) {

                    if (this.timeouts[img.id])
                    {
                        $timeout.cancel(this.timeouts[img.id]);
                    }

                    var temp = angular.copy(img);

                    this.timeouts[img.id] = $timeout(function () {
                        return temp.$update({
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

                this.sort = function (type, id, images) {
                    var order = _.pluck(images, 'id');
                    $http.post('api/admin/media/image/sort', {
                        ownerId: id,
                        ownerType: type,
                        order: order
                    });
                };
            }

            return new Service();

        });
})();