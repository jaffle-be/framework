(function () {
    'use strict';

    angular.module('media')
        .factory('Image', function ($resource) {

            var placeholders = {
                id: '@id',
            };

            var resource = $resource('api/admin/media/image/:id', placeholders, {
                list: {
                    url: 'api/admin/media/image',
                    method: 'GET',
                    isArray: true,
                    transformResponse: function (response, headers) {
                        response = angular.fromJson(response);

                        /*
                         translations are keyed by strings, and we need an object in order
                         to set a translation for an image that did not have any translation
                         in the original model. if we don't do this, the translation will never get
                         set into the translation array
                         */

                        response = _.each(response, function (item) {
                            if (item.translations.length == 0)
                            {
                                item.translations = {};
                            }
                        });

                        return response;
                    }
                },
                update: {
                    method: 'PUT'
                }
            });


            var behaviours = {
                thumbnail: function (thumbnail) {
                    if (this.path)
                    {
                        var pattern = /\/([^\/]+)$/;
                        var replace = '/' + thumbnail + '/$1';

                        return this.path.replace(pattern, replace);
                    }
                }
            };

            resource.prototype = angular.extend({}, resource.prototype, behaviours);

            return resource;
        })
        .factory('VideoResource', function ($resource) {

            var placeholders = {
                id: '@id'
            };

            return $resource('api/admin/media/video/:id', placeholders, {
                update: {
                    method: 'PUT'
                }
            });
        })
        .factory('Video', function ($resource, VideoResource, $http) {

            var video = {
                list: function (params, success) {
                    return $http({
                        url: 'api/admin/media/video',
                        method: 'GET',
                        params: params,
                        transformResponse: function (response) {
                            response = angular.fromJson(response);
                            //our videos are keyed by locale, so we need to manually handle the response
                            //angular can not figure this out on its own.
                            response = _.each(response, function (locale_videos, locale) {
                                response[locale] = _.map(locale_videos, function (video) {
                                    return new VideoResource(video);
                                });
                            });

                            return response;
                        }
                    }).then(success);
                }
            };

            return angular.extend(video, VideoResource);
        }).factory('InfographicResource', function ($resource) {

            var placeholders = {
                id: '@id'
            };

            return $resource('api/admin/media/infographic/:id', placeholders, {
                update: {
                    method: 'PUT'
                }
            });
        })
        .factory('Infographic', function ($http, InfographicResource) {

            var infographic = {
                list: function (params, success) {
                    return $http({
                        url: 'api/admin/media/infographic',
                        method: 'GET',
                        params: params,
                        transformResponse: function (response) {
                            response = angular.fromJson(response);
                            //our infographics are keyed by locale, so we need to manually handle the response
                            //angular can not figure this out on its own.
                            response = _.each(response, function (locale_graphics, locale) {
                                response[locale] = _.map(locale_graphics, function (graphic) {
                                    return new InfographicResource(graphic);
                                });
                            });

                            return response;
                        }
                    }).then(success);
                },
            };

            return $.extend(infographic, InfographicResource);
        })
        .factory('FileResource', function ($resource) {

            var placeholders = {
                id: '@id'
            };

            return $resource('api/admin/media/file/:id', placeholders, {
                update: {
                    method: 'PUT'
                }
            });
        }).factory('File', function ($http, FileResource) {

            var file = {
                list: function (params, success) {
                    return $http({
                        url: 'api/admin/media/file',
                        method: 'GET',
                        params: params,
                        transformResponse: function (response) {
                            response = angular.fromJson(response);
                            //our files are keyed by locale, so we need to manually handle the response
                            //angular can not figure this out on its own.
                            response = _.each(response, function (locale_files, locale) {
                                response[locale] = _.map(locale_files, function (file) {
                                    return new FileResource(file);
                                });
                            });

                            return response;
                        }
                    }).then(success);
                }
            };

            return $.extend(file, FileResource);
        });

})();