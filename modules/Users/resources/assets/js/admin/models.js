(function () {
    'use strict';

    angular.module('users')
        .factory('Profile', function ($resource, Skill, MediaService) {

            return $resource('api/admin/profile', {}, {
                save: {
                    method: 'POST'
                }
            });

        })
        .factory('Skill', function ($resource) {

            return $resource('api/admin/profile/skill/:id', {
                id: '@id'
            }, {
                query: {isArray: false},
                list: {
                    url: 'api/admin/profile/skill/list',
                    method: 'GET',
                    isArray: true
                },
                update: {
                    method: 'PUT'
                },
            })

        });

})();
