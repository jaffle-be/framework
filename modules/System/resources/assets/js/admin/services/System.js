(function () {
    'use strict';

    angular.module('system')
        .factory('System', function ($http, $timeout) {

            function System()
            {
                this.initialised = false;
                this.options = {};

                var me = this;

                $http.get('api/admin/system').then(function (response) {
                    me.options = response.data;
                    me.initialised = true;
                });
            }

            return new System;
        });

})();
