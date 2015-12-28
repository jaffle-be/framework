(function () {
    angular.module('app', [
        'pusher-angular',
        'ui.router',                    // Routing
        'oc.lazyLoad',                  // ocLazyLoad
        'ui.bootstrap',                 // Ui Bootstrap
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
        'as.sortable',
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
