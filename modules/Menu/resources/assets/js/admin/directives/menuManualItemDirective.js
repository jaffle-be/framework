(function () {
    'use strict';

    angular.module('menu')
        .directive('menuManualItem', function (MenuService, MenuItem) {

            return {
                restrict: 'A',
                templateUrl: '/templates/admin/menu/manual-item',
                scope: {
                    menu: '=',
                    item: '=menuManualItem',
                    locales: '=',
                },
                controller: function ($scope) {
                    this.newName = '';
                    $scope.vm = this;
                    var me = this;

                    //make sure to reset the item when selecting a different menu,
                    //but also when something else was added to the menu. or removed.
                    $scope.$watch('menu', function (newValue, oldValue) {

                        if (newValue) {
                            me.initItem();
                        }
                    });

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
                        MenuService.createItem($scope.item, function (item) {
                            $scope.menu.items.push(item);
                        });
                    };

                    this.deleteItem = function () {
                        MenuService.deleteItem($scope.item, function (response) {
                            if (!response.id) {
                                //when deleting an item that was linked to a page object,
                                //we need to add the returned page object to the available pages for that menu
                                if (response.page) {
                                    $scope.menu.availablePages.push(response.page);
                                }

                                if (response.route) {
                                    $scope.menu.availableRoutes.push(response.route);
                                }

                                _.remove($scope.menu.items, function (item) {
                                    return item.id == $scope.item.id;
                                });

                                //i don't understand why i need to call this manually? we have a watcher at the top?
                                //a watcher that works for pushing on a property array, but not for removing?
                                me.initItem();
                            }
                        });
                    };

                    this.initItem = function () {
                        $scope.item = new MenuItem({
                            menu_id: $scope.menu.id
                        });
                    }

                }
            }

        });

})();