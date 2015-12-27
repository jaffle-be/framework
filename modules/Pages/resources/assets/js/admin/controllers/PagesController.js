(function () {
    'use strict';

    angular.module('pages')
        .controller('PagesController', function ($scope, Page, PageService, $sce, System) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.options = System.options;
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.pages = [];

            var me = this;

            this.newPage = function () {
                var page = new Page();
                PageService.save(page);
            };

            this.changeTab = function (locale) {
                this.query = '';
                this.options.locales[this.options.locale].active = false;
                //set the new one and cache active one
                this.options.locales[locale].active = true;
                this.options.locale = locale;
            };

            this.activeTab = function (locale) {
                return this.locale == locale;
            };

            this.list = function (table) {
                me.table = table;
                me.loadPages()
            };

            this.getPage = function (start) {
                return Math.ceil(start / me.rpp) + 1;
            };

            this.loadPages = function () {
                me.loading = true;
                Page.query({
                    page: me.getPage(me.table.pagination.start),
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {
                    me.total = response.total;
                    me.pages = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.check = function ($event) {
                $event.stopPropagation();
                return false;
            }

            this.batchDelete = function () {
                var pages = this.selectedPages();

                PageService.batchDelete(pages, function () {
                    me.loadPages();
                });
            };

            this.batchPublish = function () {
                var pages = this.selectedPages();

                PageService.batchPublish(pages, me.options.locale, function () {

                });
            };

            this.batchUnpublish = function () {
                var pages = this.selectedPages();

                PageService.batchUnpublish(pages, me.options.locale, function () {

                });
            };

            this.selectedPages = function () {
                var pages = [];

                _.each(this.pages, function (page) {
                    if (page.isSelected) {
                        pages.push(page.id);
                    }
                });

                return pages;
            }
        });

})();
