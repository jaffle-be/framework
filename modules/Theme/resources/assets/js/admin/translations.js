(function () {
    'use strict';

    angular
        .module('theme')
        .config(function ($translateProvider) {

            $translateProvider
                .translations('en', {

                    // Define all menu elements
                    THEME: 'Theme',
                    SETTINGS: 'Settings',
                });

        });

})();