(function () {
    'use strict';

    angular.module('shop')
        .factory('PropertyService', function (PropertyGroup, PropertyValue, $timeout, $http, $q) {

            var groupTimeouts = [],
                propertyTimeouts = [],
                valueTimeouts = [];

            return {
                createGroup: createGroup,
                updateGroup: updateGroup,
                deleteGroup: deleteGroup,
                sortGroups : sortGroups,
                updateProperty: updateProperty,
                deleteProperty: deleteProperty,
                sortProperties: sortProperties,
                moveProperty: moveProperty,
                createValue: createValue,
                updateValue: updateValue,
            };

            function createGroup(category, locale, name)
            {
                var translations = {};
                translations[locale] = {
                    name: name,
                };

                var group = new PropertyGroup({
                    category_id: category.id,
                    translations: translations
                });

                return group.$save().then(function(response){
                    return response;
                });
            }

            function updateGroup(group)
            {
                if(groupTimeouts[group.id])
                {
                    $timeout.cancel(groupTimeouts[group.id]);
                }

                groupTimeouts[group.id] = $timeout(function(){

                    var copy = angular.copy(group);
                    copy.$update();

                }, 400);
            }

            function deleteGroup(group)
            {
                return group.$delete().then();
            }

            function sortGroups(groups)
            {
                return $http.post('/api/admin/shop/properties/groups/sort', {
                    order: _.pluck(groups, 'id')
                }).then(function(response){

                });
            }

            function sortProperties(properties)
            {
                return $http.post('/api/admin/shop/properties/sort', {
                    order: _.pluck(properties, 'id')
                }).then(function(response){

                });
            }

            function moveProperty(property, from, to, position)
            {
                return $http.post('/api/admin/shop/properties/move', {
                    property: property.id,
                    from: from.id,
                    to: to.id,
                    position: position
                }).then(function(response){
                    return response.data;
                });
            }

            function updateProperty(property)
            {
                if(propertyTimeouts[property.id])
                {
                    $timeout.cancel(propertyTimeouts[property.id]);
                }

                propertyTimeouts[property.id] = $timeout(function(){

                    var copy = angular.copy(property);
                    copy.$update();

                }, 400);
            }

            function deleteProperty(property)
            {
                return property.$delete().then();
            }

            function createValue(payload)
            {
                var value = new PropertyValue(payload);
                return value.$save();
            }
            
            function updateValue(value)
            {
                if(valueTimeouts[value.id])
                {
                    $timeout.cancel(valueTimeouts[value.id]);
                }

                valueTimeouts[value.id] = $timeout(function(){

                    var copy = angular.copy(value);
                    copy.$update();

                }, 400);
            }

        });



})();