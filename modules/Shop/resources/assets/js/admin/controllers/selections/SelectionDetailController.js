(function () {
    'use strict';

    angular.module('shop')
        .controller('SelectionDetailController', function ($scope, Product, ProductService, $state) {

            this.products = ProductService;

            var me = this,
                id = $state.params.id;


            this.load = function (id) {

                if (id)
                {
                    this.products.find(id, function (product) {
                        me.product = product;
                    });
                }
                else
                {
                    me.product = new Product();
                }
            };

            this.save = function () {
                ProductService.save(me.product);
            };

            this.delete = function () {
                ProductService.delete(me.product, function () {
                    $state.go('admin.product.overview');
                });
            };

            this.load(id);

        });

})();