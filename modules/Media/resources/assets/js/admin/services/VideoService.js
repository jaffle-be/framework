angular.module('media')
    .factory('VideoService', function (Video, VideoResource, $timeout, $state, $http) {

        function Service() {

            var id = $state.params.postId;
            this.timeouts = [];

            this.list = function (type, id, success) {
                return Video.list({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.search = function (mode, query, success) {
                return $http.get('api/admin/media/video/search', {
                    params: {
                        mode: mode,
                        query: query
                    }
                }).then(success);
            };

            this.addLink = function (payload, success, error) {

                if (this.timeouts['creating'])
                {
                    $timeout.cancel(this.timeouts['creating']);
                }

                this.timeouts['creating'] = $timeout(function () {
                    var video = new VideoResource(payload);

                    video.$save().then(success, error);
                }, 400);
            };

            this.update = function (type, id, video) {

                if (this.timeouts[video.id])
                {
                    $timeout.cancel(this.timeouts[video.id]);
                }

                var temp = angular.copy(video);

                this.timeouts[video.id] = $timeout(function () {
                    temp.$update({
                        ownerId: id,
                        ownerType: type
                    });
                }, 400);
            };

            this.delete = function (type, id, video, success) {
                return video.$delete({
                    ownerId: id,
                    ownerType: type
                }, success);
            };

            this.sort = function (type, id, videos) {
                var order = _.pluck(videos, 'id');
                $http.post('api/admin/media/video/sort', {
                    ownerId: id,
                    ownerType: type,
                    order: order
                });
            };
        }

        return new Service();
    });