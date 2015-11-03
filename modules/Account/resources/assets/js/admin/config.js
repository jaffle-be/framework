(function () {
    'use strict';

    angular.module('account', [])
        .config(function ($stateProvider) {

            $stateProvider
                .state('admin.account', {
                    abstract: true,
                    url: "/account",
                    template: '<ui-view/>'
                })
                .state('admin.account.contact', {
                    url: "/contact",
                    templateUrl: "templates/admin/account/contact/page",
                })
                .state('admin.account.members', {
                    url: "/members",
                    templateUrl: "templates/admin/account/members/page",
                })
                .state('admin.account.clients', {
                    url: "/clients",
                    templateUrl: "templates/admin/account/clients/page",
                });
        });

})();