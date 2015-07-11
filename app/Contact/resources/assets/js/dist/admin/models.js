angular.module('contact')
    .factory('ContactAddress', function ($resource) {
        return $resource('api/admin/contact/address/:id', {id: '@id'}, {
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