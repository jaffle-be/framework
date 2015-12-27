(function () {
    'use strict';

    angular.module('media')
        .directive('videoInput', function (VideoService, youtube) {

            return {
                restrict: 'E',
                templateUrl: 'templates/admin/media/video/widget',
                scope: {
                    locale: '=',
                    ownerId: '=',
                    ownerType: '=',
                    videos: '=',
                },
                controllerAs: 'vm',
                controller: function ($scope, Video, VideoService) {
                    var me = this;
                    //init base variables and dropzone
                    $scope.loaded = true;

                    this.url = '';

                    this.youtube = youtube;
                    this.youtube.scope = $scope;

                    this.search = function () {
                        return this.youtube.search(this.url);
                    };

                    this.setMode = function (mode) {
                        //always clear the preview when changing mode
                        this.youtube.preview = false;
                        this.youtube.mode = mode;
                    };

                    //move up means lower index
                    this.moveUp = function (video, index) {
                        if (index - 1 >= 0) {
                            this.videos[$scope.locale][index] = this.videos[$scope.locale][index - 1];
                            this.videos[$scope.locale][index - 1] = video;
                            VideoService.sort($scope.ownerType, $scope.ownerId, this.videos[$scope.locale]);
                        }
                    };

                    //move down means higher index
                    this.moveDown = function (video, index) {
                        if (index + 1 <= this.videos[$scope.locale].length - 1) {
                            this.videos[$scope.locale][index] = this.videos[$scope.locale][index + 1];
                            this.videos[$scope.locale][index + 1] = video;
                            VideoService.sort($scope.ownerType, $scope.ownerId, this.videos[$scope.locale]);
                        }
                    };

                    this.updateVideo = function (video) {
                        VideoService.update($scope.ownerType, $scope.ownerId, video);
                    };

                    this.deleteVideo = function (video) {
                        VideoService.delete($scope.ownerType, $scope.ownerId, video, function () {
                            _.remove($scope.videos[$scope.locale], function (value, index, array) {
                                return value.id == video.id;
                            });
                        });
                    };

                    this.init = function () {
                        VideoService.list($scope.ownerType, $scope.ownerId, function (response) {
                            $scope.videos = response.data;
                            $scope.loaded = true;
                        });
                    };

                }

            }


        });
})();