(function () {
    angular.module('app', [
        'ui.router',                    // Routing
        'oc.lazyLoad',                  // ocLazyLoad
        'ui.bootstrap',                 // Ui Bootstrap
        'pascalprecht.translate',       // Angular Translate
        'ngIdle',                       // Idle timer
        'smart-table',                  //smart table
        'system',
        'blog',
        'ngResource',
        'ngStorage',
        'ngCookies',
        'account',
        'contact',
        'system',
        'marketing',
    ])
})();
// Other libraries are loaded dynamically in the config.js file using the library ocLazyLoad