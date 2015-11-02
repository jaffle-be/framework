(function () {
    'use strict';

    angular.module('portfolio', [])
        .config(function ($stateProvider) {

            $stateProvider
                .state('admin.portfolio', {
                    abstract: true,
                    url: "/portfolio",
                    template: '<ui-view/>'
                })
                .state('admin.portfolio.overview', {
                    url: "/overview",
                    templateUrl: "templates/admin/portfolio/overview"
                })
                .state('admin.portfolio.detail', {
                    url: '/detail/:id',
                    templateUrl: "templates/admin/portfolio/detail"
                });
        });

})();