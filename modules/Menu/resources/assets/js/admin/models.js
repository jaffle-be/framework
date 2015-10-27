angular.module('menu')

    .factory('MenuItem', function ($resource) {
        return new $resource('api/admin/menu/:menu_id/menu-item/:id', {
            menu_id: '@menu_id',
            id: '@id',
        }, {
            update: {
                method: 'PUT'
            },
        });
    })

    .factory('Menu', function ($resource, $http, MenuItem) {
        return new $resource('api/admin/menu/:id', {
            id: '@id'
        }, {
            list: {
                method: 'GET',
                isArray: true,
                transformResponse: function (response) {
                    var menus = angular.fromJson(response);

                    _.each(menus, function (menu, key) {

                        menus[key].items = _.each(menu.items, function (item, key) {
                            menu.items[key] = new MenuItem(item);
                        });

                    });

                    return menus;
                }
            }
        });
    });