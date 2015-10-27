angular.module('menu')
    .factory('MenuService', function ($timeout, $http, Menu, MenuItem, toaster) {

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

                var destination = angular.copy(item);

                if (!delayed)
                {
                    return destination.$update({}, success);
                }

                if (this.timeout)
                {
                    $timeout.cancel(this.timeout);
                }

                this.timeout = $timeout(function () {
                    destination.$update({}, success);
                }, 400);
            },
            createItem: function (item, success) {
                return item.$save({}).then(success, function(response){
                    if(response.status == 422)
                    {
                        _.each(response.data, function(item){
                            toaster.pop('error', item[0]);
                        });
                    }
                });
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