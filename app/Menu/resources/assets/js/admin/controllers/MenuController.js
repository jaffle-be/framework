angular.module('menu')
    .controller('MenuController', function (MenuService, MenuItem) {
        this.newName = '';
        this.menus = [];
        //active menu
        this.menu = {};

        //the item we are editing
        this.item;

        this.initialised = false;

        //init a new manual item
        this.newItem = function () {
            this.item = new MenuItem({
                menu_id: me.menu.id
            });
        };

        this.availablePages = [
            {
                id: 1,
                translations: {
                    nl: {
                        title: 'test nl',
                    },
                    en: {
                        title: 'test en',
                    }
                }
            },
            {
                id: 2,
                translations: {
                    nl: {
                        title: 'test nl 2',
                    },
                    en: {
                        title: 'test en 2',
                    }
                }
            }
        ];

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

        this.saveSort = function()
        {
            MenuService.sort(this.menu);
        };

        //load inital menus
        MenuService.list(function (response) {
            me.menus = response;
            me.menu = me.menus[0];
            //the form is visible, so we need a empty object from the start.
            me.item = new MenuItem({
                menu_id: me.menu.id
            });
            me.initialised = true;
        });

    });