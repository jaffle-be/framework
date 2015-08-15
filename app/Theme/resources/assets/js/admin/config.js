angular.module('theme', [])
    .config(function ($stateProvider) {

        $stateProvider
            .state('admin.theme', {
                abstract: true,
                url: "/theme",
                template: '<ui-view/>'
            })
            .state('admin.theme.settings', {
                url: "/settings",
                templateUrl: "templates/admin/theme/settings"
            });

    });