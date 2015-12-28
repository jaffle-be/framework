(function () {
    'use strict';

    angular.module('menu')
        .controller('MenuController', function (MenuService, MenuItem, System) {
            this.options = {};
            this.menus = [];
            //active menu
            this.menu = {};
            this.tabs = {
                manual: true,
                page: false,
                route: false,
            };

            var me = this;

            System.then(function(){
                me.options = System.options;
            });

            //the item we are editing
            this.item;

            this.initialised = false;

            //init a new manual item
            this.newItem = function () {
                this.item = new MenuItem({
                    menu_id: me.menu.id
                });
                this.selectTab('manual');
            };

            this.startEditing = function (item) {
                this.selectTab('manual');
                this.item = item
            };

            this.selectMenu = function (menu) {
                this.menu = menu;
            };

            this.selectTab = function (tab) {
                _.each(this.tabs, function (active, type) {
                    me.tabs[type] = false;
                });

                this.tabs[tab] = true;
            };

            this.sortables = {
                orderChanged: function (event) {
                    me.saveSort()
                }
            };

            this.createMenu = function () {
                MenuService.create(this.newName, function (menu) {
                    me.newName = '';
                    me.menus.push(menu);
                });
            };

            this.deleteMenu = function () {
                MenuService.remove(this.menu, function (response) {
                    if (!response.id) {
                        _.remove(me.menus, function (item) {
                            return item.id == me.menu.id;
                        });
                    }
                });
            };

            this.saveSort = function () {
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

})();
