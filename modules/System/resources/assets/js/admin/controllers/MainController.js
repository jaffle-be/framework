(function () {
    'use strict';

    function MainController($scope, toaster, Pusher, $window) {

        Pusher.then(function()
        {
            Pusher.channel.bind('system.hard-reload', function () {
                $window.location.reload();
            });
        });

        this.multipleLocales = function (locales) {
            return _.keys(locales).length > 1;
        };

        this.toaster = {
            'time-out': 3000,
            'close-button': true,
            'progress-bar': true
        };
    }

    angular
        .module('system')
        .controller('MainController', MainController);

})();
