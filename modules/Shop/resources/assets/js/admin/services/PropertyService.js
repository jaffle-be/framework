(function () {
    'use strict';

    angular.module('shop')
        .factory('PropertyService', function ($timeout, $http, $q) {

            return {
                sortGroups : sortGroups,
                sortProperties: sortProperties,
                moveProperty: moveProperty
            };

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