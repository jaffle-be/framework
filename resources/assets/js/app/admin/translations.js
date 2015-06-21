function config($translateProvider) {

    $translateProvider
        .translations('en', {

            // Define all menu elements
            DASH: 'Dashboard',
            BLOG: 'Blog',
            SHOP: 'Shop',
            PRODUCTS: 'Products',

            // Define some custom text
            WELCOME: 'Welcome Amelia',
            MESSAGEINFO: 'You have 42 messages and 6 notifications.',
            SEARCH: 'Search for something...',

        });

    $translateProvider.preferredLanguage('en');

}

angular
    .module('app')
    .config(config)
