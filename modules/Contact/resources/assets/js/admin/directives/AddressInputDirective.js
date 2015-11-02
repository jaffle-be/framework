(function () {
    'use strict';

    angular.module('contact')
        .directive('addressInput', function () {
            return {
                restrict: 'A',
                templateUrl: 'templates/admin/contact/address/widget',
                scope: {
                    id: '=addressId',
                    owner_type: '=addressOwnerType',
                    owner_id: '=addressOwnerId'
                },

                controller: function ($scope, AddressService, ContactAddress) {

                    this.$address = AddressService;
                    $scope.address = new ContactAddress();
                    $scope.searched = false;
                    $scope.ctrl = this;

                    var me = this;

                    var formInputs = {
                        street_number: {
                            name: 'box',
                            type: 'short_name',

                        },
                        country: {
                            name: 'country.iso_code_2',
                            type: 'short_name',
                        },
                        locality: {
                            name: 'city',
                            type: 'long_name'
                        },
                        postal_code: {
                            name: 'postcode',
                            type: 'long_name',
                        },
                        route: {
                            name: 'street',
                            type: 'long_name',
                        }
                    };

                    this.save = function () {

                        $scope.address.owner_id = $scope.owner_id;
                        $scope.address.owner_type = $scope.owner_type;

                        this.$address.save($scope.address, function (address) {
                            $scope.addres = address;
                            $scope.errors = [];
                        }, function (response) {
                            $scope.errors = response.data;
                        });

                    };

                    function clearValues() {
                        for (var geoValueKey in formInputs)
                        {
                            var input = formInputs[geoValueKey];
                            var dot = input.name.indexOf('.');

                            //check for subrelations.
                            if (dot == -1)
                            {
                                $scope.address[input.name] = '';
                            }
                            else
                            {
                                var related = input.name.substring(0, dot);
                                var name = input.name.substring(dot + 1);

                                if ($scope.address[related])
                                {
                                    $scope.address[related][name] = '';
                                }
                            }
                        }
                    };

                    function setValues(place) {
                        // Get each component of the address from the place details
                        // and fill the corresponding field on the form.
                        for (var i = 0; i < place.address_components.length; i++)
                        {

                            // each address component is provided with some types to add a meaning to the data.
                            // we use the first added meaning, as this should always be the one we need.
                            // the others are less commonly used ones
                            var addressType = place.address_components[i].types[0];

                            var component = formInputs[addressType];

                            //apply the actual value to the scope if the component exists.
                            if (component)
                            {

                                var dot = component.name.indexOf('.');
                                //check for subrelations
                                if (dot == -1)
                                {
                                    $scope.address[component.name] = place.address_components[i][component.type];
                                }
                                else
                                {
                                    var related = component.name.substring(0, dot);
                                    var name = component.name.substring(dot + 1);

                                    if (!$scope.address[related])
                                    {
                                        $scope.address[related] = {};
                                    }

                                    $scope.address[related][name] = place.address_components[i][component.type];
                                }
                            }
                        }
                    };

                    function fillInAddress(place) {

                        clearValues();
                        setValues(place);

                        $scope.searched = true;

                        //also set the coordinates
                        $scope.address.latitude = place.geometry.location.lat();
                        $scope.address.longitude = place.geometry.location.lng();

                        $scope.$digest();
                    };

                    function mapWithAutocomplete(mapOptions) {
                        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                        $scope.map = map;

                        var input = document.getElementById("address_suggest");

                        var autocomplete = new google.maps.places.Autocomplete(input);
                        autocomplete.bindTo('bounds', map);
                        return {map: map, autocomplete: autocomplete};
                    }

                    function addMarker(map) {
                        $scope.marker = new google.maps.Marker({
                            map: $scope.map,
                            anchorPoint: new google.maps.Point(0, -29)
                        });
                        $scope.marker.setPosition(map.center);
                        $scope.marker.setVisible(true);
                    }

                    this.initMap = function () {
                        //a global default, showing some non important spot in brussels
                        var mapOptions = {
                            center: {lat: 50.8503396, lng: 4.351710300000036},
                            zoom: 16
                        };

                        //override to the actuall address if one provided.
                        if ($scope.address.latitude && $scope.address.longitude)
                        {
                            mapOptions.center = {
                                lat: $scope.address.latitude,
                                lng: $scope.address.longitude
                            };
                        }

                        var __ret = mapWithAutocomplete(mapOptions);
                        var map = __ret.map;
                        var autocomplete = __ret.autocomplete;

                        addMarker(map);

                        google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
                            var place = autocomplete.getPlace();
                            if (!place.geometry)
                            {
                                return;
                            }

                            // If the place has a geometry, then present it on a map.
                            if (place.geometry.viewport)
                            {
                                $scope.map.fitBounds(place.geometry.viewport);
                            } else
                            {
                                var bounds = new google.maps.LatLngBounds();
                                bounds.extend(place.geometry.location);
                                $scope.map.setCenter(place.geometry.location);
                                $scope.map.fitBounds(bounds);
                                $scope.map.setZoom(16);  // Why 16? Because it looks good.
                            }
                            $scope.marker.setIcon(/** @type {google.maps.Icon} */({
                                url: place.icon,
                                size: new google.maps.Size(71, 71),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(35, 35)
                            }));
                            $scope.marker.setPosition(place.geometry.location);
                            $scope.marker.setVisible(true);

                            fillInAddress(place);

                            return false;
                        });
                    };

                    if ($scope.id)
                    {
                        this.$address.find($scope.id, function (address) {
                            $scope.address = address;
                            $scope.searched = true;
                            me.initMap();
                        });
                    }
                    else
                    {
                        $scope.address = new ContactAddress();
                        me.initMap();
                    }


                }
            };
        });

})();