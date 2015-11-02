(function () {
    'use strict';

    angular.module('users', [])
        .config(function ($stateProvider) {
            $stateProvider
                .state('admin.profile', {
                    url: "/profile",
                    templateUrl: 'templates/admin/users/profile'
                })
        });


})();