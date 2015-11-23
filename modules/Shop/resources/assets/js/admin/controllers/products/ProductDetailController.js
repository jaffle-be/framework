(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Product, ProductService, PropertyService, $state, $sce) {

            this.products = ProductService;

            $scope.groupSortingHandlers = {
                itemMoved: function (event) {

                },
                orderChanged: function(event) {
                    PropertyService.sortGroups(me.product.propertyGroups);
                }
            };

            $scope.propertySortingHandlers = {
                itemMoved: function (event) {
                    var property = event.source.itemScope.modelValue;
                    var from = event.source.sortableScope.$parent.group;
                    var to = event.dest.sortableScope.$parent.group;

                    var position = event.dest.index;

                    _.each(event.dest.sortableScope.modelValue, function(item, key){

                        if(item.id == property.id)
                        {
                            position = key
                        }
                    });

                    PropertyService.moveProperty(property, from, to, position);
                },
                orderChanged: function(event) {
                    var properties = event.dest.sortableScope.modelValue;
                    PropertyService.sortProperties(properties);
                }
            };

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