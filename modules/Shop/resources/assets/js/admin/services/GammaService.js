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
                searchCategory: function(data){
                    return $http.post('/api/admin/shop/categories/suggest', data);
                },
                searchBrand: function(data){
                    return $http.post('/api/admin/shop/brands/suggest', data);
                }
            };

        });

})();