(function () {
    'use strict';

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
        })
        .factory('SocialLinks', function ($resource) {
            return $resource('api/admin/contact/social-links/:id', {id: '@id'}, {
                find: {
                    method: 'GET'
                },
                update: {
                    method: 'PUT'
                }
            });
        });

})();