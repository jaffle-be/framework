angular.module('menu')
    .directive('menuPageItem', function (MenuService, MenuItem) {

        return {
            restrict: 'A',
            templateUrl: '/templates/admin/menu/page-item',
            scope: {
                menu: '=',
                item: '=menuPageItem',
                locales: '=',
                locale: '=',
            },
            controller: function ($scope) {
                this.selectedPage = '';
                //active menu
                $scope.vm = this;
                var me = this;

                this.pageName = function(page)
                {
                    if(page.translations[$scope.locale] && page.translations[$scope.locale].title)
                    {
                        return page.translations[$scope.locale].title
                    }

                    var name;

                    _.each(page.translations, function(item){
                        if(item.title)
                        {
                            name = item.title;
                        }
                    });

                    return name;
                };

                this.saveItem = function (delayed) {
                    //only save existing
                    if (!$scope.item.id)
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
                    if (this.selectedPage)
                    {
                        var created = new MenuItem({
                            menu_id: $scope.menu.id,
                            page_id: me.selectedPage
                        });

                        MenuService.createItem(created, function (item) {
                            $scope.menu.items.push(item);
                            _.remove($scope.menu.availablePages, function(page)
                            {
                                return page.id == me.selectedPage;
                            });
                            me.selectedPage = false;
                        });
                    }
                };

                this.deleteItem = function () {
                    MenuService.deleteItem($scope.item, function (response) {
                        if (!response.id)
                        {
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