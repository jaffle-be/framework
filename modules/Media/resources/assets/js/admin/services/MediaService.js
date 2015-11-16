(function () {
    'use strict';

    angular.module('media')
        .factory('MediaService', function (Image, VideoResource, InfographicResource, FileResource) {

            return {
                transformResponse: function (response) {
                    _.each(response.images, function (image, i) {
                        response.images[i] = new Image(image);
                    });

                    _.each(response.videos, function (translation) {
                        _.each(translation, function (video, i) {
                            translation[i] = new VideoResource(video);
                        })
                    });

                    _.each(response.infographics, function (translation) {
                        _.each(translation, function (infographic, i) {
                            translation[i] = new InfographicResource(infographic);
                        })
                    });

                    _.each(response.files, function (translation) {
                        _.each(translation, function (file, i) {
                            translation[i] = new FileResource(file);
                        })
                    });

                    return response;
                }
            }

        });
})();