(function () {
    'use strict';

    angular.module('shop')
        .factory('ProductService', function (Product, $timeout, $http) {

            return {
                find: function (id, success) {
                    Product.get({id: id}, success);
                },
                query: function (params, success) {
                    Product.query(params, success);
                },
                save: function (product, success) {
                    if (product.id)
                    {
                        //use a copy, so the response will not reset the form to the last saved instance while typing.
                        var destination = angular.copy(product);

                        if (this.timeout)
                        {
                            $timeout.cancel(this.timeout);
                        }

                        this.timeout = $timeout(function () {
                            return destination.$update(success);
                        }, 400);
                    }
                    else
                    {
                        product.$save({}, success);
                    }
                },
                delete: function (product, success) {
                    product.$delete().then(success);
                },
                batchDelete: function (products, success) {
                    $http.post('/api/admin/products/batch-delete', {
                        products: products
                    }).then(success);
                },
                batchPublish: function (products, locale, success) {
                    $http.post('/api/admin/products/batch-publish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },
                batchUnpublish: function (products, locale, success) {
                    $http.post('/api/admin/products/batch-unpublish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },

            };

        });

})();