(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Product, ProductService, PropertyService, PropertySortingService, $state, $sce) {

            this.products = ProductService;
            this.newGroup = '';
            this.product = false;
            //helper to locking property sorting when sorting groups

            var me = this,
                id = $state.params.id;

            this.load = function (id) {

                if (id)
                {
                    this.products.find(id, function (product) {
                        me.product = product;
                        $scope.sorting = PropertySortingService.init(product);
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

            this.createGroup = function()
            {
                var category = _.first(me.product.propertyGroups).category_id;
                category = _.first(_.where(me.product.categories, {id: category}));
                PropertyService.createGroup(category, me.options.locale, me.newGroup).then(function(group){
                    me.newGroup = '';
                    me.product.propertyGroups.push(group);
                    me.product.baseProperties[group.id] = [];
                });
            };

            this.load(id);

        });

})();