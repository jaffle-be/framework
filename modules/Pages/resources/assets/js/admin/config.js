(function () {
    'use strict';

    angular.module('pages', [])
        .config(function ($stateProvider) {

            $stateProvider
                .state('admin.pages', {
                    abstract: true,
                    url: "/pages",
                    template: '<ui-view/>'
                })
                .state('admin.pages.overview', {
                    url: "/overview",
                    templateUrl: "templates/admin/pages/overview"
                })
                .state('admin.pages.page', {
                    url: '/page/:id',
                    templateUrl: "templates/admin/pages/detail"
                });
        });

})();