(function () {
    'use strict';

    angular.module('users')
        .factory('ProfileService', function (Profile, $timeout) {
            return {
                find: function (success) {
                    Profile.find(success);
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