(function () {
    'use strict';

    angular.module('blog')
        .factory('Blog', function ($resource, Image) {
            return $resource('api/admin/blog/:id', {id: '@id'}, {
                query: {
                    isArray: false
                },
                get: {
                    method: 'GET',
                    transformResponse: function (response) {
                        response = angular.fromJson(response);

                        if (response.translations.length == 0)
                        {
                            response.translations = {};
                        }

                        _.each(response.translations, function (translation) {
                            if (translation.publish_at)
                            {
                                translation.publish_at = moment(translation.publish_at, 'YYYY-MM-DD').format('DD/MM/YYYY')
                            }
                        });

                        response.images = _.map(response.images, function (image) {
                            return new Image(image);
                        });

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                    transformRequest: function (data) {
                        _.each(data.translations, function (item) {
                            if (typeof item.publish_at == "string")
                            {
                                var date = moment(item.publish_at, 'DD/MM/YYYY');
                                item.publish_at = date.format('YYYY-MM-DD');
                            }

                            if (item.publish_at instanceof Date)
                            {
                                var date = moment(item.publish_at)
                                item.publish_at = date.format('YYYY-MM-DD');
                            }

                        });

                        return angular.toJson(data);
                    }
                }
            });
        });

})();