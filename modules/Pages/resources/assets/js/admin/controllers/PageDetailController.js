(function () {
    'use strict';

    angular.module('pages')
        .controller('PageDetailController', function ($scope, $state, Page, PageService, System) {
            this.options = System.options;
            this.pages = PageService;
            $scope.status = {
                datepickerStatus: false
            };

            var me = this,
                id = $state.params.id;

            this.load = function (id) {
                if (id) {
                    this.page = this.pages.find(id, function (page) {
                        me.page = page;
                    });
                }
                else {
                    this.page = new Page();
                }
            };

            /**
             * trigger a save for a document that exists but hold the autosave when it's a
             * document we're creating.
             *
             *
             */
            this.save = function () {
                var me = this;
                me.drafting = true;

                if (me.page.id) {
                    this.pages.save(me.page);
                }
            };

            this.publish = function () {
                var me = this;
                this.pages.publish(this.page, function () {
                    me.drafting = false;
                });
            };

            this.openDatepicker = function ($event) {
                $scope.status.datepickerStatus = !$scope.status.datepickerStatus;
                $event.preventDefault();
                $event.stopPropagation();
            };

            this.delete = function () {
                this.pages.delete(me.page, function () {
                    $state.go('admin.pages.overview');
                });
            };

            this.load(id);
        });

})();
