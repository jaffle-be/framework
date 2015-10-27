angular
    .module('portfolio')
    .config(function($translateProvider) {

        $translateProvider
            .translations('en', {

                // Define all menu elements
                PORTFOLIO: 'Portfolio',
            });

    });