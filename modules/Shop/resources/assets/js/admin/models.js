(function () {
    'use strict';

    angular.module('shop')
        .factory('Product', function ($resource) {
            return $resource('api/admin/shop/products/:id', {id: '@id'}, {
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

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                }
            });
        })

        .factory('ProductSelection', function ($resource) {
            return $resource('api/admin/shop/gamma/selections/:id', {id: '@id'}, {
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

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                }
            });
        });

})();