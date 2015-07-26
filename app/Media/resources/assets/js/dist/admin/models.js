angular.module('media')
    .factory('Image', function ($resource) {

        var placeholders = {
            id: '@id',
        };

        return $resource('api/admin/media/image/:id', placeholders, {
            list: {
                url: 'api/admin/media/image',
                method: 'GET',
                isArray: true,
                transformResponse: function(response, headers)
                {
                    response = angular.fromJson(response);

                    /*
                        translations are keyed by strings, and we need an object in order
                        to set a translation for an image that did not have any translation
                        in the original model. if we don't do this, the translation will never get
                        set into the translation array
                     */

                    response = _.each(response, function(item)
                    {
                        if(item.translations.length == 0)
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
    });