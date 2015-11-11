(function () {
    'use strict';

    angular.module('shop')
        .factory('GammaService', function ($timeout, $http) {

            return {
                brands: function (params, success) {
                    return $http.get('/api/admin/brands', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                brand: function (brand, status) {
                    return $http.post('/api/admin/brands', {
                        brand: brand,
                        status: status
                    });
                },

                categories: function (params, success) {
                    return $http.get('/api/admin/categories', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                category: function (category, status) {
                    return $http.post('/api/admin/categories', {
                        category: category,
                        status: status
                    });
                },
                detail: function (data, success, error) {
                    return $http.post('/api/admin/gamma/detail', data).then(success, error);
                }
            };

        });

})();