(function () {
    'use strict';

    angular.module('shop')
        .directive('productPropertyCreator', ProductPropertyCreator);

    function ProductPropertyCreator() {
        return {
            restrict: 'E',
            templateUrl: '/templates/admin/shop/property-creator',
            translude: true,
            scope: {
                //are we in creation mode?
                open: '=',
                //the group we're creating a property for
                group: '=',
                //all the properties, so we can add the new property to that list
                properties: '=',
                //known units
                units: '=',
                //current locale
                locale: '=',
            },
            controller: InputController,
            controllerAs: 'vm',
            bindToController: true,
        }
    }

    InputController.$inject = ['PropertyService', 'Property'];
    function InputController(PropertyService, Property) {

        this.newProperty = {
            translations: {}
        };

        this.newUnit = {
            translations: {}
        };

        this.services = {
            properties: PropertyService,
        };
        this.models = {
            property: Property
        };

        this.creatingUnit = false;
        this.createProperty = createProperty;
        this.resetPropertyInput = resetPropertyInput;
        this.cancelCreating = cancelCreating;
        this.saveUnit = saveUnit;
    }


    function createProperty()
    {
        var me = this;
        var property = new me.models.property(this.newProperty);
        property.group_id = me.group.id;

        property.$save().then(function(response){
            me.open = false;
            me.properties[me.group.id].push(property);
        });
    }

    function resetPropertyInput()
    {
        this.newProperty = {
            translations: {}
        };

        this.newUnit = {
            translations: {}
        };
    }

    function cancelCreating()
    {
        this.resetPropertyInput();
        this.open = false;
    }

    function saveUnit()
    {
        var me = this;

        //cancel when still creating
        if (me.creatingUnit)
        {
            return false;
        }

        if(me.newProperty.unit_id)
        {
            var unit = me.units[me.newProperty.unit_id];

            me.services.properties.updateUnit(unit);
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
    }


})();