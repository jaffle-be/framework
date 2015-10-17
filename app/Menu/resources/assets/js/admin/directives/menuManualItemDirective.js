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

                this.saveItem = function (delayed) {
                    //only save existing
                    if(!$scope.item.id)
                    {
                        return;
                    }

                    if (typeof delayed === 'undefined')
                    {
                        delayed = true;
                    }

                    MenuService.saveItem($scope.item, delayed);

                };

                this.createItem = function () {
                    MenuService.createItem($scope.item, function (item) {
                        $scope.menu.items.push(item);
                        $scope.item = new MenuItem({
                            menu_id: $scope.menu.id
                        })
                    });
                };

                this.deleteItem = function()
                {
                    MenuService.deleteItem($scope.item, function(response)
                    {
                        if(!response.id)
                        {
                            //when deleting an item that was linked to a page object,
                            //we need to add the returned page object to the available pages for that menu
                            if(response.page)
                            {
                                $scope.menu.availablePages.push(response.page);
                            }

                            _.remove($scope.menu.items, function(item)
                            {
                                return item.id == $scope.item.id;
                            });

                            $scope.item = false;
                        }
                    });
                };

            }
        }

    });