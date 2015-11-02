(function () {
    'use strict';

    angular.module('users')
        .controller('ProfileController', function (ProfileService, SkillService) {
            this.profile = {};
            this.profileErrors = [];
            this.loaded = false;
            var me = this;

            this.load = function () {
                ProfileService.find(function (profile) {
                    me.profile = profile;
                    me.loaded = true;
                });
            };

            this.save = function () {
                ProfileService.save(me.profile, function () {
                    me.profileErrors = [];
                }, function (response) {
                    me.profileErrors = response.data;
                });
            };


            this.updateSkill = function (skill) {
                SkillService.update(skill);
            };

            this.deleteSkill = function (skill) {
                SkillService.delete(skill, _.remove(me.profile.skills, function (value, index, array) {
                    return value.id == skill.id
                }));
            };

            this.searchSkill = function (value) {
                return SkillService.search(me.options.locale, value).then(function (response) {
                    return response.data;
                });
            };

            this.createSkill = function () {
                SkillService.create(me.options.locale, me.input, function (skill) {
                    me.profile.skills.push(skill);
                    me.input = '';
                });
            };

            this.addSkill = function ($item) {
                SkillService.link($item, function (response) {
                    me.profile.skills.push(response);
                    me.input = "";
                });
            };

            this.load();
        });

})();