(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Product, ProductService, PropertyService, PropertySortingService, $state, $sce) {

            this.products = ProductService;
            this.newGroup = '';
            this.product = false;
            this.creatingValues = [];
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

            this.updateGroup = function(group)
            {
                PropertyService.updateGroup(group);
            };

            this.deleteGroup = function(group)
            {
                PropertyService.deleteGroup(group).then(function(response){
                    if(response.status == 'oke')
                    {
                        _.remove(me.product.baseProperties, function(item, key){
                            return key == group.id;
                        });

                        _.remove(me.product.propertyGroups, function(item){
                            return item.id == group.id;
                        });
                    }
                });
            };

            this.canDeleteGroup = function(group)
            {
                return me.product.baseProperties[group.id].length == 0;
            };

            this.updateProperty = function(property)
            {
                PropertyService.updateProperty(property);
            };

            this.deleteProperty = function(property)
            {
                PropertyService.deleteProperty(property).then(function(response){
                    if(response.status == 'oke')
                    {
                        _.remove(me.product.baseProperties[group.id], function(item){
                            return item.id == property.id;
                        });

                        _.remove(me.product.properties, function(item)
                        {
                            return item.property_id == property.id;
                        });
                    }
                });
            };

            this.updateValue = function(property)
            {
                var value = me.product.properties[property.id];

                //if we're creating already for this property, don't do anything
                if(me.creatingValues[property.id])
                {
                    return;
                }

                //if the value has no id, it will be a new value.
                if(!value.id)
                {
                    me.creatingValues[property.id] = true;
                    value.product_id = me.product.id;
                    value.property_id = property.id;
                    PropertyService.createValue(value).then(function(response)
                    {
                        //set id, free future updates, and perform a last sync for updated entries.
                        value = angular.extend(response, value);
                        me.creatingValues[property.id] = false;
                        value.$update();
                    });
                }
                else{
                    PropertyService.updateValue(value);
                }
            };

            this.load(id);

        });

})();