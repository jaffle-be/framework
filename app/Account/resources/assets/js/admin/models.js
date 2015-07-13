angular.module('account')
    .factory('AccountContactInformation', function ($resource) {
        return $resource('api/admin/account/account-contact-information/:id', {
            id: '@id'
        }, {
            load: {
                method: 'GET',
            },
            update:{
                method: 'PUT',
            }
        });
    });