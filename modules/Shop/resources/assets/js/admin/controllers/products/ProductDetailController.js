(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Product, ProductService, PropertyService, PropertySortingService, $state, $sce) {

            this.products = ProductService;
            this.newGroup = '';
            this.product = false;
            this.creatingValues = [];
            this.creatingOptions = [];
            this.creatingProperty = false;
            this.creatingPropertyForGroup = false;

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

            this.createGroup = function () {
                var category = _.first(_.where(me.product.categories, {original_id: null}));
                PropertyService.createGroup(category, me.options.locale, me.newGroup).then(function (group) {
                    me.newGroup = '';
                    me.product.propertyGroups.push(group);
                    me.product.propertyProperties[group.id] = [];
                });
            };

            this.updateGroup = function (group) {
                PropertyService.updateGroup(group);
            };

            this.deleteGroup = function (group) {
                PropertyService.deleteGroup(group).then(function (response) {
                    if (response.status == 'oke')
                    {
                        _.remove(me.product.propertyProperties, function (item, key) {
                            return key == group.id;
                        });

                        _.remove(me.product.propertyGroups, function (item) {
                            return item.id == group.id;
                        });
                    }
                });
            };

            this.canDeleteGroup = function (group) {
                return me.product.propertyProperties[group.id].length == 0;
            };

            this.updateProperty = function (property) {
                PropertyService.updateProperty(property);
            };

            this.deleteProperty = function (property) {
                PropertyService.deleteProperty(property).then(function (response) {
                    _.remove(me.product.propertyProperties[property.group_id], function (item) {
                        return item.id == property.id;
                    });

                    _.remove(me.product.properties, function (item) {
                        return item.property_id == property.id;
                    });
                });
            };

            this.updateValue = function (property) {
                var value = me.product.properties[property.id];

                //if we're creating already for this property, don't do anything
                if (me.creatingValues[property.id])
                {
                    return;
                }

                //if the value has no id, it will be a new value.
                if (!value.id)
                {
                    me.creatingValues[property.id] = true;
                    value.product_id = me.product.id;
                    value.property_id = property.id;
                    PropertyService.createValue(value).then(function (response) {
                        //set id, free future updates, and perform a last sync for updated entries.
                        value = angular.extend(response, value);
                        me.creatingValues[property.id] = false;
                        me.product.properties[property.id] = value;
                        PropertyService.updateValue(value);
                    });
                }
                else
                {
                    PropertyService.updateValue(value);
                }
            };

            this.saveOption = function (property) {
                var value = me.product.properties[property.id];

                //cancel when still creating
                if (me.creatingOptions[property.id])
                {
                    return false;
                }

                if (typeof value !== 'undefined' && value.option_id)
                {
                    var option = me.product.propertyOptions[property.id][value.option_id];
                    PropertyService.updateOption(option);
                }
                else
                {
                    //if the select already had something selected,
                    //a newly created item will be added to the propertyOptions object
                    //under the key null (not as string 'null').
                    //if nothing was selected, it'll be under the key undefined (not as string 'undefined')
                    var keyForNewItem = typeof me.product.propertyOptions[property.id][undefined] != 'undefined' ? undefined : null;

                    var option = me.product.propertyOptions[property.id][keyForNewItem];

                    me.creatingOptions[property.id] = true;
                    option.property_id = property.id;
                    PropertyService.createOption(option, function (response) {

                        //set id, free future updates, add it to the select, and actually select it and
                        option = angular.extend(response, option);
                        //unlock option creating or saving
                        me.creatingOptions[property.id] = false;
                        //add the new option to the existing options.
                        me.product.propertyOptions[property.id][option.id] = option;
                        //reset the value corresponding to 'option for creating a new property option'
                        delete me.product.propertyOptions[property.id][keyForNewItem];
                        //select the actual newly created option
                        me.product.properties[property.id] = {
                            option_id: option.id
                        };
                        //perform a last sync in case we kept typing in the box, which is usually the case.
                        PropertyService.updateOption(option);
                        //also trigger updating the value.
                        me.updateValue(property);
                    });
                }
            };

            this.deleteValue = function (property) {
                var value = me.product.properties[property.id];

                value.$delete().then(function (response) {
                    me.product.properties[property.id] = null;
                });
            };

            this.startCreatingProperty = function (group) {
                me.creatingProperty = true;
                me.creatingPropertyForGroup = group;
            };

            this.updateUnit = function(property)
            {
                var unit = me.product.propertyUnits[property.unit_id];
                PropertyService.updateUnit(unit);
            };

            this.load(id);

        });

})();