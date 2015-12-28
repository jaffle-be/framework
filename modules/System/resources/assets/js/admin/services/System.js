(function () {
    'use strict';

    angular.module('system')
        .factory('System', function ($http, $timeout) {

            function System()
            {
                var me = this;
                this.initialised = false;
                this.options = {};

                var promise = $http.get('api/admin/system').then(function (response) {
                    me.options = response.data;
                    me.initialised = true;
                });

                this.then = function(success, error)
                {
                    promise.then(success, error);
                }
            }

            var system = new System;

            return system;
        });

})();
