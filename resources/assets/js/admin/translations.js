angular
    .module('app')
    .config(function($translateProvider) {

        $translateProvider
            .translations('en', {

                // Define all menu elements
                DASH: 'Dashboard',
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

            });

        $translateProvider.preferredLanguage('en');

    });