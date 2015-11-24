(function () {
    'use strict';

    angular.module('shop')
        .factory('PropertyService', function (PropertyGroup, $timeout, $http, $q) {

            return {
                createGroup: createGroup,
                sortGroups : sortGroups,
                sortProperties: sortProperties,
                moveProperty: moveProperty
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

        });



})();