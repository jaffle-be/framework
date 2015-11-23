(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Product, ProductService, $state, $sce) {

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
                ProductService.save(me.product).then(function (response) {
                    me.product.translations[me.options.locale].slug = response.translations[me.options.locale].slug
                });
            };

            this.delete = function () {
                ProductService.delete(me.product, function () {
                    $state.go('admin.shop.products');
                });
            };

            this.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            this.load(id);

        });

})();