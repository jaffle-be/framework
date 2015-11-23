(function () {
    'use strict';

    angular.module('shop')
        .factory('ProductSelectionService', function (ProductSelection, $timeout, $http) {

            return {
                find: function (id, success) {
                    ProductSelection.get({id: id}, success);
                },
                query: function (params, success) {
                    ProductSelection.query(params, success);
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
                batchPublish: function (products, locale, success) {
                    $http.post('/api/admin/shop/gamma/selections/batch-publish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },
                batchUnpublish: function (products, locale, success) {
                    $http.post('/api/admin/shop/gamma/selections/batch-unpublish', {
                        products: products,
                        locale: locale
                    }).then(success);
                },
                searchSelection: function(query, locale)
                {
                    var data = {
                        query:query,
                        locale: locale
                    };
                    return $http.post('/api/admin/shop/gamma/selections/suggest', data).then(function(response){
                        return response.data;
                    });
                },

            };

        });

})();