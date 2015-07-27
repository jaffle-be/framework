angular.module('users')
    .controller('ProfileController', function (ProfileService) {
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
            ProfileService.save(me.profile, function()
            {
                me.profileErrors = [];
            }, function(response)
            {
                me.profileErrors = response.data;
            });
        };

        this.load();
    });