(function () {
    'use strict';

    angular.module('pages')

        .factory('PageService', function (Page, $state, $timeout, $http) {

            function Service() {
                //when creating, it should get locked so it won't trigger another save, till we have the id back from the server.
                this.locked = false;
                this.timeout = false;

                var me = this;

                this.find = function (id, success) {
                    //also pass through the locale parameter (not the UI locale, but the input locale for the page itself
                    Page.get({id: id}, success);
                };

                this.save = function (page) {

                    //use a copy, so the response will not reset the form to the last saved instance while typing.
                    var destination = angular.copy(page);

                    if (this.locked)
                        return;

                    if (!destination.id)
                    {
                        this.locked = true;

                        return destination.$save(function () {
                            me.locked = false;
                            $state.go('admin.pages.page', {id: destination.id});
                        });
                    }
                    else
                    {
                        if (this.timeout)
                        {
                            $timeout.cancel(this.timeout);
                        }

                        this.timeout = $timeout(function () {
                            return destination.$update(function () {
                                _.each(page.translations, function (item, locale) {
                                    item.slug = destination.translations[locale].slug
                                });
                            });
                        }, 400);
                    }
                };

                this.delete = function (page, success) {
                    page.$delete().then(success);
                };

                this.batchDelete = function (pages, success) {
                    $http.post('/api/admin/pages/batch-delete', {
                        pages: pages
                    }).then(success);
                };

                this.link = function (parent, page, success) {
                    $http.post('/api/admin/pages/link-subpage', {
                        parent: parent.id,
                        page: page.id
                    }).then(success);
                };

                this.unlink = function (parent, page, success) {
                    $http.post('/api/admin/pages/unlink-subpage', {
                        parent: parent.id,
                        page: page.id
                    }).then(success);
                };

                this.sortSubpages = function (page) {
                    var order = _.pluck(page.children, 'id');
                    $http.post('/api/admin/pages/sort-subpages', {
                        page: page.id,
                        order: order
                    });
                };

                this.batchPublish = function (pages, locale, success) {
                    $http.post('/api/admin/pages/batch-publish', {
                        pages: pages,
                        locale: locale
                    }).then(success);
                };

                this.batchUnpublish = function (pages, locale, success) {
                    $http.post('/api/admin/pages/batch-unpublish', {
                        pages: pages,
                        locale: locale
                    }).then(success);
                };
            }

            return new Service();
        });

})();