angular.module('media')
    .factory('InfographicService', function (Infographic, $timeout, $state, $http) {

        function Service() {

            var id = $state.params.postId;
            this.timeouts = [];

            //infographic uploader
            this.uploader = function (type, id, locale, handlers) {

                if(typeof handlers === 'function')
                {
                    //handlers is only a success callback
                    handlers = {
                        success: handlers
                    };
                }

                return {
                    options: {
                        url: 'api/admin/media/infographic',
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
                return Infographic.list({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.update = function (type, id, graphic) {

                if (this.timeouts[graphic.id])
                {
                    $timeout.cancel(this.timeouts[graphic.id]);
                }

                var temp = angular.copy(graphic);

                this.timeouts[graphic.id] = $timeout(function () {
                    return temp.$update({
                        ownerId: id,
                        ownerType: type
                    });
                }, 400);
            };

            this.delete = function (type, id, graphic, success) {
                return graphic.$delete({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.sort = function(type, id, graphics)
            {
                var order = _.pluck(graphics, 'id');
                $http.post('api/admin/media/infographic/sort', {
                    ownerId: id,
                    ownerType: type,
                    order: order
                });
            };

        }

        return new Service();

    });