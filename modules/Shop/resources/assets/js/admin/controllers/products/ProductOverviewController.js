(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductOverviewController', function (Product, ProductService, GammaService, $state, $scope, $sce, toaster, System) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.options = {};
            this.loading = true;
            this.creating = false;
            this.creatingProduct = {};
            this.rpp = 15;
            this.total = 0;
            this.products = [];

            var me = this;

            this.getPage = function (start) {
                return Math.ceil(start / this.rpp) + 1;
            };

            this.list = function (table) {

                me.table = table;
                me.loading = true;
                //cannot use this here
                var page = me.getPage(table.pagination.start);

                me.loadProducts(page);
            };

            this.loadProducts = function (page) {
                var me = this;

                Product.query({
                    page: page,
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {

                    me.total = response.total;
                    me.products = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.selectBrandForCreation = function (brand) {
                me.creatingProduct.brand_id = brand.value;
            };

            this.startCreating = function () {
                me.creating = true;
            };

            this.cancelCreating = function () {
                me.creating = false;
                me.creatingProduct = {};
            };

            this.createProduct = function () {
                var product = new Product(me.creatingProduct);

                ProductService.save(product).then(function (newProduct) {
                    $state.go('admin.shop.product', {id: newProduct.id});
                }, function (response) {

                    if (response.status == 422) {
                        _.each(response.data, function (errors) {
                            toaster.error(errors[0]);
                        });
                    }
                });
            };

            this.delete = function () {
                var products = this.selectedProducts();

                ProductService.batchDelete(products, function () {
                    me.loadProducts();
                });

            };

            this.batchDelete = function () {
                var products = this.selectedProducts();

                ProductService.batchDelete(products, function () {
                    me.loadProducts();
                });
            };

            this.batchPublish = function () {
                var products = this.selectedProducts();

                ProductService.batchPublish(products, me.options.locale, function () {

                });
            };

            this.batchUnpublish = function () {
                var products = this.selectedProducts();

                ProductService.batchUnpublish(products, me.options.locale, function () {

                });
            };

            this.selectedProducts = function () {
                var products = [],
                    me = this;

                _.each(this.products, function (product) {
                    if (product.isSelected) {
                        products.push(product.id);
                    }
                });

                return products;
            };

            this.getTitle = function (product) {
                return ProductService.getTitle(product, me.options.locale);
            };

            this.searchProduct = function (query) {
                return ProductService.searchProduct(query, me.options.locale);
            };

            this.searchBrand = function (query) {
                return GammaService.searchBrand({
                    query: query,
                    locale: me.options.locale
                });
            };

            this.goTo = function (item) {
                $state.go('admin.shop.product', {id: item.value});
            };
        }
    )

})();
