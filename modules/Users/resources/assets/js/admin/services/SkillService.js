(function () {
    'use strict';

    angular.module('users')
        .factory('SkillService', function (Skill, $timeout) {
            function Service() {

                this.searching = false;
                this.timeouts = [];

                var me = this;

                this.update = function (skill) {

                    var temp = angular.copy(skill);

                    if (this.timeouts[skill.id]) {
                        $timeout.cancel(this.timeouts[skill.id]);
                    }

                    this.timeouts[skill.id] = $timeout(function () {
                        return temp.$update({});
                    }, 400);
                };

                this.create = function (locale, name, success) {
                    var skill = new Skill({
                        locale: locale,
                        name: name
                    });

                    skill.$save({}, success);
                };

                this.link = function (skill, success) {
                    skill = new Skill(skill);
                    skill.$update({}, success);
                };

                this.delete = function (skill, success, error) {
                    return skill.$delete({}).then(success, error);
                };

                this.search = function (locale, value) {

                    return Skill.query({
                        value: value,
                        locale: locale
                    }).$promise;
                };

            }

            return new Service();
        });

})();