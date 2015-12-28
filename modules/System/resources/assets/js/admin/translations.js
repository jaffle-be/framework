(function () {
    'use strict';

    angular
        .module('system')
        .config(function ($translateProvider) {

            $translateProvider
                .translations('en', {

                    // Define all menu elements
                    DASH: 'Dashboard',
                    PAGES: 'Pages',
                    BLOG: 'Blog',
                    SHOP: 'Shop',
                    CONTACT: 'Contact',
                    ACCOUNT: 'Account',
                    USERS: 'Users',
                    CLIENTS: 'Clients',
                    MARKETING: 'Marketing',


                    // Define some custom text
                    SEARCH: 'Search anything',
                    REMOVE: 'Remove',
                    CANCEL: 'Cancel',
                    CONFIRM: 'Are you sure you want to do this?',

                })

                .translations('nl', {

                    // Define all menu elements
                    DASH: 'Dashboard',
                    PAGES: "Pagina's",
                    BLOG: 'Blog',
                    SHOP: 'Shop',
                    CONTACT: 'Contact',
                    ACCOUNT: 'Account',
                    USERS: 'Gebruikers',
                    CLIENTS: 'Klanten',
                    MARKETING: 'Marketing',


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
