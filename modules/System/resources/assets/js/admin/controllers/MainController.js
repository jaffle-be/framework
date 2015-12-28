(function () {
    'use strict';

    function MainController($scope, toaster, Pusher, $window) {

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
