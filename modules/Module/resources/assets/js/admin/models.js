(function () {
    'use strict';

    angular.module('module')
        .factory('Module', function ($http) {
            return {
                toggle: function (module) {
                    $http.post('api/admin/module/toggle', module);
                }
            }
        });

})();