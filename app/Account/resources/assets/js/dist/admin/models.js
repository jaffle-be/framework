angular.module('account')
    .factory('Account', function ($resource) {
        return $resource('api/admin/account/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            get: {
                method: 'GET'
            },
            update: {
                method: 'PUT'
            }
        });
    });