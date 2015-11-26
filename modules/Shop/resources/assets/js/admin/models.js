(function () {
    'use strict';

    angular.module('shop')
        .factory('Product', function ($resource, Category, PropertyService) {
            return $resource('api/admin/shop/products/:id', {id: '@id'}, {
                query: {
                    isArray: false
                },
                get: {
                    method: 'GET',
                    transformResponse: function (response, something, status) {

                        if(status == 200)
                        {
                            response = angular.fromJson(response);

                            if (response.translations.length == 0)
                            {
                                response.translations = {};
                            }

                            response.categories = _.map(response.categories, function (category) {
                                return new Category(category);
                            });

                            PropertyService.transformResponse(response);

                        }

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
        })

        .factory('PropertyGroup', function($resource){
            return $resource('api/admin/shop/properties/groups/:id', {id: '@id'}, {
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

        .factory('Property', function($resource){
            return $resource('api/admin/shop/properties/:id', {id: '@id'}, {
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

        .factory('PropertyOption', function($resource){
            return $resource('api/admin/shop/properties/options/:id', {id: '@id'}, {
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

        .factory('PropertyValue', function($resource){
            return $resource('api/admin/shop/properties/values/:id', {id: '@id'}, {
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