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
    ])
})();
// Other libraries are loaded dynamically in the config.js file using the library ocLazyLoad


/**
 * This resource will allow us to retrieve all system related information.
 *
 * F.E, the current user information, the UI locale and preferred resource locale
 */

angular.module('system', [])

    .factory('system', function()
    {
        //need to return an object that resembles all configurations
        //we should only fetch it once and store it.
        return {
            user: {},
            locale: 'en',
            locales: ['en', 'nl', 'fr', 'de'],
            rpp: 40
        };

    })

    .filter('myDate', function() {
        return function(dateString) {
            return moment(new Date(dateString)).format('DD/MM/YYYY')
        };
    })

    .filter('fromNow', function()
    {
        return function(dateString) {
            return moment(new Date(dateString)).fromNow()
        };
    })

    .controller('MainCtrl', function () {

        //a holder for all ui alerts.
        this.alerts = [];

        this.addAlert = function () {
            this.alerts.push({msg: 'Another alert!'});
        };

        this.closeAlert = function (index) {
            this.alerts.splice(index, 1);
        };


    });