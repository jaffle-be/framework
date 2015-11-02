(function () {
    angular.module('app', [
        'pusher-angular',
        'ui.router',                    // Routing
        'oc.lazyLoad',                  // ocLazyLoad
        'ui.bootstrap',                 // Ui Bootstrap
        'pascalprecht.translate',       // Angular Translate
        'ngIdle',                       // Idle timer
        'smart-table',                  //smart table
        'toaster',
        'system',
        'tags',
        'media',
        'menu',
        'blog',
        'users',
        'ngResource',
        'ngStorage',
        'ngCookies',
        //carefull, ui.sortable will change to as.sortable in the future (probably because of the same name as the other library)
        'ui.sortable',
        'account',
        'contact',
        'system',
        'marketing',
        'portfolio',
        'theme',
        'theme-active',                 //the active theme should use this scope to load
        'pages',
        'module',
        'shop'
    ])
})();