(function () {
    'use strict';

    angular.module('shop')
        .factory('Product', function ($resource, Category) {
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

                        response.categories = _.map(response.categories, function (category) {
                            return new Category(category);
                        });

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                }
            });
        })

        .factory('Category', function ($resource) {

            var placeholders = {
                id: '@id',
            };

            return $resource('api/admin/shop/categories/:id', placeholders, {
                list: {
                    url: 'api/admin/shop/categories/list',
                    method: 'GET',
                    isArray: true
                },
                update: {
                    method: 'PUT'
                },
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