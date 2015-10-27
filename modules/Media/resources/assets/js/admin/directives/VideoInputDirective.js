angular.module('media')
    .directive('videoInput', function (VideoService, toaster, $q) {

        var youtube = {
            mode: 'youtube',
            preview: false,
            loading: false,
            input: {
                url: '',
                title: '',
            },
            search: function () {
                //only search for a video if the link field doesn't start with http:// or https://
                //or 'does not have a url value' but very loosely validated.
                var pattern = /https?:\/\//;
                if (typeof this.input.url == 'string' && !pattern.test(this.input.url))
                {
                    return VideoService.search(this.mode, this.input.url, function (response) {
                        return response.data;
                    });
                }

                //if we do have a url, we still need to return an empty result to satisfy typeahead.
                //this needs to be done using a promise object.
                var deferred = $q.defer();

                deferred.resolve({data: []});

                return deferred.promise;
            },
            title: function (video) {
                return video && video.title;
            },
            date: function (video) {
                return video ? moment(video.publishedAt) : null;
            },
            select: function (video) {
                this.preview = video;
            },
            img: function(video)
            {
                return video ? video.provider_thumbnail : null;
            },
            description: function(video)
            {
                return video ? video.description : null;
            },
            id: function(video)
            {
                return video ? video.provider_id : null;
            },
            addVideo: function (videos, locale, owner_type, owner_id) {

                var me = this;

                //if we have a preview -> we use the preview
                //else we'll send the query (which we expect to be a url)
                //and let the server handle the parsing for the id and url.
                //we'll get it back from the answer and use that to add to the videos array.

                var success = function (video) {
                    if(!videos[locale])
                    {
                        videos[locale] = [];
                    }

                    videos[locale].push(video);
                    me.input.url = '';
                    me.input.title = '';
                    me.preview = false;
                };

                var error = function (response) {

                    //make sure the response is not a full html document.
                    //why? this would pop a toast for each character in that document :-)
                    if(typeof response.data == 'string')
                    {
                        toaster.error(response.data);
                    }
                };

                var payload = {
                    mode: this.mode,
                    ownerType: owner_type,
                    ownerId: owner_id,
                    translations: {},
                    title: this.input.title,
                    description: this.input.description,
                    locale: locale
                };

                if(this.preview)
                {
                    payload.provider_id = this.id(this.preview);
                }
                else{
                    payload.url = this.input.url;
                }

                VideoService.addLink(payload, success, error);
            }
        };

        return {
            restrict: 'E',
            templateUrl: 'templates/admin/media/video/widget',
            scope: {
                locale: '=',
                ownerId: '=',
                ownerType: '=',
            },
            controller: function ($scope, Video, VideoService) {
                var me = this;
                //init base variables and dropzone
                $scope.loaded = false;
                $scope.ctrl = this;

                this.url = '';

                this.youtube = youtube;
                this.youtube.scope = $scope;

                this.search = function()
                {
                    return this.youtube.search(this.url);
                };

                this.setMode = function(mode)
                {
                    //always clear the preview when changing mode
                    this.youtube.preview = false;
                    this.youtube.mode = mode;
                };

                //move up means lower index
                this.moveUp = function (video, index) {
                    if (index - 1 >= 0)
                    {
                        this.videos[$scope.locale][index] = this.videos[$scope.locale][index - 1];
                        this.videos[$scope.locale][index - 1] = video;
                        VideoService.sort($scope.ownerType, $scope.ownerId, this.videos[$scope.locale]);
                    }
                };

                //move down means higher index
                this.moveDown = function (video, index) {
                    if (index + 1 <= this.videos[$scope.locale].length - 1)
                    {
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
                        _.remove(me.videos[$scope.locale], function (value, index, array) {
                            return value.id == video.id;
                        });
                    });
                };

                this.init = function () {
                    VideoService.list($scope.ownerType, $scope.ownerId, function (response) {
                        me.videos = response.data;
                        $scope.loaded = true;
                    });
                };

                this.init();
            }

        }


    });