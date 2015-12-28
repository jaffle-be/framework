(function () {
    'use strict';

    angular.module('users')
        .factory('ProfileService', function (Profile, Skill, MediaService, $timeout) {
            return {
                transformResponse: function (response) {
                    var data = angular.fromJson(response);

                    if (data.translations.length == 0) {
                        data.translations = {};
                    }

                    var skills = [];

                    _.each(data.skills, function (item) {
                        skills.push(new Skill(item));
                    });

                    data.skills = skills;

                    return MediaService.transformResponse(data);
                },
                save: function (profile, success, error) {
                    if (this.timeout) {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function () {

                        Profile.save(profile, success, error);

                    }, 400);
                }
            }
        });

})();
