(function () {
    'use strict';

    angular.module('menu')
        .directive('menuRouteItem', function (MenuService, MenuItem) {

            return {
                restrict: 'A',
                templateUrl: '/templates/admin/menu/route-item',
                scope: {
                    menu: '=',
                    item: '=menuRouteItem',
                    locales: '=',
                    locale: '=',
                },
                controller: function ($scope) {
                    this.selectedRoute = '';
                    //active menu
                    $scope.vm = this;
                    var me = this;

                    this.routeName = function (route) {
                        if (route.translations[$scope.locale] && route.translations[$scope.locale].title) {
                            return route.translations[$scope.locale].title
                        }

                        var name;

                        _.each(route.translations, function (item) {
                            if (item.title) {
                                name = item.title;
                            }
                        });

                        return name;
                    };

                    this.saveItem = function (delayed) {
                        //only save existing
                        if (!$scope.item.id) {
                            return;
                        }

                        if (typeof delayed === 'undefined') {
                            delayed = true;
                        }

                        MenuService.saveItem($scope.item, delayed);

                    };

                    this.createItem = function () {
                        if (this.selectedRoute) {
                            var created = new MenuItem({
                                menu_id: $scope.menu.id,
                                module_route_id: me.selectedRoute
                            });

                            MenuService.createItem(created, function (item) {
                                $scope.menu.items.push(item);
                                _.remove($scope.menu.availableRoutes, function (route) {
                                    return route.id == me.selectedRoute;
                                });
                                me.selectedRoute = false;
                            });
                        }
                    };

                    this.deleteItem = function () {
                        MenuService.deleteItem($scope.item, function (response) {
                            if (!response.id) {
                                _.remove($scope.menu.items, function (item) {
                                    return item.id == $scope.item.id;
                                });

                                $scope.item = false;
                            }
                        });
                    };

                }
            }

        });

})();