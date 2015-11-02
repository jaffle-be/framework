(function () {
    'use strict';

    angular.module('theme')
        .factory('Theme', function ($resource) {
            return new $resource('api/admin/theme/:id', {id: '@id'}, {
                list: {
                    method: 'GET',
                    isArray: true,
                },
                current: {
                    url: 'api/admin/theme/current',
                    method: 'GET',
                }
            });
        });

})();