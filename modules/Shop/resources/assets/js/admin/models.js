angular.module('shop')
    .factory('Product', function ($resource) {
        return $resource('api/admin/products/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            get: {
                method: 'GET',
                transformResponse: function(response)
                {
                    response = angular.fromJson(response);

                    if(response.translations.length == 0)
                    {
                        response.translations = {};
                    }

                    return response;
                }
            },
            update: {
                method: 'PUT',
            }
        });
    });