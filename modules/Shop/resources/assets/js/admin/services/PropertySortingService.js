(function () {
    'use strict';


    angular.module('shop').factory('PropertySortingService', function (PropertyService) {

        function Service() {
            var me = this;

            this.product = false;
            this.init = function (product) {
                this.product = product;

                return this;
            };
            this.changingGroup = false;
            this.changingProperty = false;
            this.groupSortingHandlers = {
                accept: function () {
                    //do not allow moving properties to a group spot
                    return !me.changingProperty;
                },
                dragStart: function () {
                    me.changingGroup = true;
                },
                dragEnd: function () {
                    me.changingGroup = false;
                },
                itemMoved: function (event) {
                    //do not allow moving a group between properties
                    event.dest.sortableScope.removeItem(event.dest.index);
                    event.source.itemScope.sortableScope.insertItem(event.source.index, event.source.itemScope.group);
                },
                orderChanged: function (event) {
                    PropertyService.sortGroups(me.product.propertyGroups);
                }
            };
            this.propertySortingHandlers = {
                accept: function (sourceScope, destScope, destItemScope) {
                    //if we return false here when we're changing groups, we can make sure groups can't be put
                    //into another group
                    return !me.changingGroup;
                },
                dragStart: function () {
                    me.changingProperty = true;
                },
                dragEnd: function () {
                    me.changingProperty = false;
                },
                itemMoved: function (event) {
                    var property = event.source.itemScope.modelValue;
                    var from = event.source.sortableScope.$parent.group;
                    var to = event.dest.sortableScope.$parent.group;

                    var position = event.dest.index;

                    _.each(event.dest.sortableScope.modelValue, function (item, key) {

                        if (item.id == property.id) {
                            position = key
                        }
                    });

                    PropertyService.moveProperty(property, from, to, position);
                },
                orderChanged: function (event) {
                    var properties = event.dest.sortableScope.modelValue;
                    PropertyService.sortProperties(properties);
                }
            }
        }

        return new Service();
    });

})
();