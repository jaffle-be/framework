angular.module('menu')
    .controller('MenuController', function (MenuService, MenuItem) {
        this.newName = '';
        this.menus = [];
        //active menu
        this.menu = {};

        this.sortables = {
            orderChanged: function(event) {
                me.saveSort()
            }
        };

        var me = this;

        this.createMenu = function () {
            MenuService.create(this.newName, function (menu) {
                me.newName = '';
                me.menus.push(menu);
            });
        };

        this.deleteMenu = function () {
            MenuService.remove(this.menu, function (response) {
                if (!response.id)
                {
                    _.remove(me.menus, function (item) {
                        return item.id == me.menu.id;
                    });
                }
            });
        };

        this.saveItem = function (delayed) {
            //only save existing
            if(!this.item.id)
            {
                return;
            }

            if (typeof delayed === 'undefined')
            {
                delayed = true;
            }

            MenuService.saveItem(this.item, delayed);

        };

        this.newItem = function () {
            this.item = new MenuItem({
                menu_id: me.menu.id
            });
        };

        this.createItem = function () {
            MenuService.createItem(this.item, function (item) {
                me.menu.items.push(item);
            });
        };

        this.deleteItem = function()
        {
            MenuService.deleteItem(this.item, function(response)
            {
                if(!response.id)
                {
                    _.remove(me.menu.items, function(item)
                    {
                        return item.id == me.item.id;
                    });

                    me.item = false;
                }
            });
        };

        this.saveSort = function()
        {
            MenuService.sort(this.menu);
        };

        //load inital menus
        MenuService.list(function (response) {
            me.menus = response
            me.menu = me.menus[0];
        });

    });