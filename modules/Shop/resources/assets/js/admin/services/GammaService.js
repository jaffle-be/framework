(function () {
    'use strict';

    angular.module('shop')
        .factory('GammaService', function ($timeout, $http) {

            return {
                brands: function (params, success) {
                    return $http.get('/api/admin/shop/gamma/brands', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                brand: function (brand, status) {
                    return $http.post('/api/admin/shop/gamma/brands', {
                        brand: brand,
                        status: status
                    });
                },

                categories: function (params, success) {
                    return $http.get('/api/admin/shop/gamma/categories', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                category: function (category, status) {
                    return $http.post('/api/admin/shop/gamma/categories', {
                        category: category,
                        status: status
                    });
                },
                detail: function (data, success, error) {
                    return $http.post('/api/admin/shop/gamma/detail', data).then(success, error);
                },

                //these shouldn't be here, but the product controller is already to bloated
                //and these one method per dedicated controller is a reasonably bad idea.
                //it might be good in the future, for brand creation, but not for now
                searchCategory: function (data) {
                    return $http.post('/api/admin/shop/categories/suggest', data).then(function (response) {
                        return response.data;
                    });
                },
                searchBrand: function (data) {
                    return $http.post('/api/admin/shop/brands/suggest', data).then(function (response) {
                        return response.data;
                    });
                }
            };

        });

})();