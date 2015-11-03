(function () {
    'use strict';

    angular.module('marketing', [])
        .config(function ($stateProvider) {

            $stateProvider
                .state('admin.marketing', {
                    abstract: true,
                    url: "/marketing",
                    template: '<ui-view/>'
                })
                .state('admin.marketing.overview', {
                    url: "/overview",
                    templateUrl: "templates/admin/marketing/overview"
                });
        });

})();