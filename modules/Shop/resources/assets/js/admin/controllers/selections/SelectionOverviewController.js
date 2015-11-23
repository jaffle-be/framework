(function () {
    'use strict';

    angular.module('shop')
        .controller('SelectionOverviewController', function (ProductSelection, ProductService, ProductSelectionService, $state, $scope, $sce) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.selections = [];

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

                ProductSelection.query({
                    page: page,
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {

                    me.total = response.total;
                    me.selections = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.newProduct = function () {
                var product = new ProductSelection();
                ProductSelectionService.save(product, function (newProduct) {
                    $state.go('admin.product.detail', {id: newProduct.id});
                });
            };

            this.delete = function () {
                var selections = this.selectedProducts();

                ProductService.batchDelete(selections, function () {
                    me.loadProducts();
                });

            };

            this.batchPublish = function () {
                var selections = this.selectedProducts();

                ProductSelectionService.batchPublish(selections, me.options.locale, function () {

                });
            };

            this.batchUnpublish = function () {
                var selections = this.selectedProducts();

                ProductSelectionService.batchUnpublish(selections, me.options.locale, function () {

                });
            };

            this.selectedProducts = function () {
                var selections = [],
                    me = this;

                _.each(this.selections, function (product) {
                    if (product.isSelected)
                    {
                        selections.push(product.id);
                    }
                });

                return selections;
            };

            this.getTitle = function(product)
            {
                return ProductService.getTitle(product, me.options.locale);
            };

            this.searchSelection = function(query)
            {
                return ProductSelectionService.searchSelection(query, me.options.locale);
            };

            this.goTo = function(item)
            {
                $state.go('admin.shop.selection', {id: item.value});
            };

        });

})();