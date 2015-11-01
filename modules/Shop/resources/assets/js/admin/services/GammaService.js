angular.module('shop')
    .factory('GammaService', function ($timeout, $http) {

        return Service = {
            brands: function (page, success) {
                $http.get('/api/admin/brands', {
                    page: page
                }).then(function (response) {
                    success(response.data);
                });
            },
            brand: function (brand, status) {
                $http.post('/api/admin/brands', {
                    brand: brand,
                    status: status
                });
            },

            categories: function (page, success) {
                $http.get('/api/admin/categories', {
                    page: page
                }).then(function (response) {
                    success(response.data);
                });
            },
            category: function (category, status) {
                $http.post('/api/admin/categories', {
                    category: category,
                    status: status
                });
            },
            detail: function(data, success, error)
            {
                $http.post('/api/admin/gamma/detail', data).then(success, error);
            }
        };

    });