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
                .state('admin.marketing.campaigns', {
                    url: "/campaigns",
                    templateUrl: "templates/admin/marketing/newsletter/overview"
                })
                .state('admin.marketing.campaign', {
                    url: '/campaign/:id',
                    templateUrl: "templates/admin/marketing/newsletter/detail",
                });
        });

})();