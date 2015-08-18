angular.module('menu')
    .factory('MenuService', function ($timeout, $http, Menu, MenuItem) {

        return {

            list: function (success) {
                return Menu.list({}, success);
            },
            create: function (name, success) {
                var menu = new Menu();
                menu.name = name;

                menu.$save({}, success);
            },
            remove: function (menu, success) {
                menu.$delete({}, success);
            },
            saveItem: function (item, delayed, success) {
                if (!delayed)
                {
                    return item.$update({}, success);
                }

                if (this.timeout)
                {
                    $timeout.cancel(this.timeout);
                }

                this.timeout = $timeout(function () {
                    item.$update({}, success);
                }, 400);
            },
            createItem: function (item, success) {
                return item.$save({}, success);
            },
            deleteItem: function (item, success) {
                return item.$delete({}, success);
            },
            sort: function (menu, success) {
                var order = _.pluck(menu.items, 'id');
                $http.post('api/admin/menu/' + menu.id + '/sort', {order: order}).then(success);
            }
        }

    });