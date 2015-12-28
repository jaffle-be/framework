(function () {
    'use strict';

    angular.module('system')
        .factory('System', function ($http, $timeout, ProfileService, $state) {

            function System() {
                var me = this;
                this.initialised = false;
                this.options = {}
                this.user = {};
                this.pusher = {};

                this.promise = $http.get('api/admin/system').then(function (response) {
                    me.options = response.data.options;
                    me.pusher = response.data.pusher;
                    me.user = ProfileService.transformResponse(response.data.user);
                    me.initialised = true;
                });

                this.then = function (success, error) {
                    me.promise.then(success, error);
                }

                //check if user has locale set, if not, redirect to the profile page!
                this.then(function () {
                    if (!me.user.locale_id) {
                        $state.go('admin.profile');
                    }
                });
            }

            var system = new System;

            return system;
        })

})();
