angular.module('tags')
    .factory('Tag', function ($resource) {

        var placeholders = {
            id: '@id',
        };

        return $resource('api/admin/tag/:id', placeholders, {
            query: {isArray: false},
            list: {
                url: 'api/admin/tag/list',
                method: 'GET',
                isArray: true
            },
            update: {
                method: 'PUT'
            },
        });
    });