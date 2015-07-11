angular.module('account', [])
    .config(function($stateProvider) {

        $stateProvider
            .state('admin.account', {
                abstract: true,
                url: "/account",
                template: '<ui-view/>'
            })
            .state('admin.account.contact', {
                url: "/contact",
                templateUrl: "templates/admin/account/contact/page",
            });
    });