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
                    WELCOME: 'Welcome Amelia',
                    MESSAGEINFO: 'You have 42 messages and 6 notifications.',
                    SEARCH: 'Search for something...',
                    REMOVE: 'Remove',
                    CANCEL: 'Cancel',
                    CONFIRM: 'Are you sure you want to do this?',

                });

            $translateProvider.preferredLanguage('en');
            $translateProvider.useSanitizeValueStrategy('escape');

        });


})();