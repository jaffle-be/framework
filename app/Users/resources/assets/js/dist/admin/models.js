angular.module('users')
    .factory('Profile', function($resource){

        return $resource('api/admin/profile', {}, {
            find: {
                method: 'GET'
            },
            save: {
                method: 'POST'
            }
        });

    });