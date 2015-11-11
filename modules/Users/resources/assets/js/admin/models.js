(function () {
    'use strict';

    angular.module('users')
        .factory('Profile', function ($resource, Skill, MediaService) {

            return $resource('api/admin/profile', {}, {
                find: {
                    method: 'GET',
                    transformResponse: function (response) {
                        var data = angular.fromJson(response);

                        if (data.translations.length == 0)
                        {
                            data.translations = {};
                        }

                        var skills = [];

                        _.each(data.skills, function (item) {
                            skills.push(new Skill(item));
                        });

                        data.skills = skills;

                        return MediaService.transformResponse(data);
                    }
                },
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