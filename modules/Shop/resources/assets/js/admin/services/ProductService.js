(function () {
    'use strict';

    angular.module('shop')
        .factory('ProductService', function (Product, $timeout, $http, $q, toaster, $state) {

            return {
                find: function (id, success) {
                    Product.get({id: id}).$promise.then(success, function(response){

                        if(response.status == 404)
                        {
                            toaster.error("Couldn't find product");
                            $state.go('admin.shop.products');
                        }
                        else{
                            toaster.error("something bad happened");
                            $state.go('admin.shop.products');
                        }
                    });
                },
                query: function (params, success) {
                    Product.query(params, success);
                },
                save: function (product) {
                    if (product.id)
                    {
                        //use a copy, so the response will not reset the form to the last saved instance while typing.
                        var destination = angular.copy(product);
                        var deferred = $q.defer();

                        if (this.timeout)
                        {
                            this.previousDeferred.reject('canceled for new save');
                            $timeout.cancel(this.timeout);
                        }

                        this.timeout = $timeout(function () {
                            return destination.$update().then(function(response){

                                deferred.resolve(response);
                            }, function(response){
                                deferred.reject(response);
                            });
                        }, 400);

                        this.previousDeferred = deferred;

                        return deferred.promise;
                    }
                    else
                    {
                        return product.$save({});
                    }
                },
                delete: function (product, success) {
                    product.$delete().then(success);
                },
                batchDelete: function (products, success) {
                    $http.post('/api/admin/shop/products/batch-delete', {
                        products: products
                    }).then(success);
                },
                batchPublish: function (products, locale, success) {
                    $http.post('/api/admin/shop/products/batch-publish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },
                batchUnpublish: function (products, locale, success) {
                    $http.post('/api/admin/shop/products/batch-unpublish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },
                searchProduct: function(query, locale)
                {
                    var data = {
                        query:query,
                        locale: locale
                    };
                    return $http.post('/api/admin/shop/products/suggest', data).then(function(response){
                        return response.data;
                    });
                },
                getTitle: function(product, locale)
                {
                    var brand = product.brand.translations[locale].name;

                    product = product.translations[locale].name;

                    if(!brand)
                    {
                        return product;
                    }

                    return product + ' - ' + brand;
                },

                addCategory: function(payload)
                {
                    return $http.post('api/admin/shop/products/add-category', payload).then(function(response){
                        return response.data;
                    });
                },
                removeCategory: function(payload)
                {
                    return $http.post('api/admin/shop/products/remove-category', payload).then(function(response){
                        return response.data;
                    });
                }

            };

        });

})();