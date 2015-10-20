angular.module('media')
    .factory('FileService', function (File, $timeout, $state, $http) {

        function Service() {

            var id = $state.params.postId;
            this.timeouts = [];

            //file uploader
            this.uploader = function (type, id, locale, handlers, ownerIdCallback) {

                if(typeof handlers === 'function')
                {
                    //handlers is only a success callback
                    handlers = {
                        success: handlers
                    };
                }

                return {
                    options: {
                        url: 'api/admin/media/file',
                        params: {
                            ownerType: type,
                            ownerId: id,
                            locale: locale
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
            };

            this.list = function (type, id, success) {
                return File.list({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.update = function (type, id, file) {

                if (this.timeouts[file.id])
                {
                    $timeout.cancel(this.timeouts[file.id]);
                }

                var temp = angular.copy(file);

                this.timeouts[file.id] = $timeout(function () {
                    return temp.$update({
                        ownerId: id,
                        ownerType: type
                    });
                }, 400);
            };

            this.delete = function (type, id, file, success) {
                return file.$delete({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.sort = function(type, id, files)
            {
                var order = _.pluck(files, 'id');
                $http.post('api/admin/media/file/sort', {
                    ownerId: id,
                    ownerType: type,
                    order: order
                });
            };

        }

        return new Service();

    });