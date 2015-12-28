(function () {
    'use strict';

    angular
        .module('system')
        .config(function ($translateProvider) {

            $translateProvider
                .translations('en', {
                    // Define some custom text
                    SEARCH: 'Search anything',
                    REMOVE: 'Remove',
                    CANCEL: 'Cancel',
                    CONFIRM: 'Are you sure you want to do this?',

                })

                .translations('nl', {
                    // Define some custom text
                    SEARCH: 'Zoek om het even wat',
                    REMOVE: 'Verwijderen',
                    CANCEL: 'Annuleren',
                    CONFIRM: 'Ben je zeker dat je dit wil doen?',

                });

            moment.locale('en');
            $translateProvider.preferredLanguage('en');
            $translateProvider.useSanitizeValueStrategy('escape');
        });


})();
