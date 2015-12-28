(function (Pace) {
    'use strict';

    angular.module('system', [])

        .filter('myDate', function () {
            return function (dateString) {
                return moment(new Date(dateString)).format('DD/MM/YYYY')
            };
        })

        .filter('fromNow', function () {
            return function (dateString) {
                return moment(new Date(dateString)).fromNow()
            };
        });

    angular
        .module('system')
        .config(function ($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, IdleProvider, KeepaliveProvider, $httpProvider, $locationProvider) {

            Pace.options.ajax.trackMethods.push('POST');

            // Configure Idle settings
            IdleProvider.idle(5); // in seconds
            IdleProvider.timeout(120); // in seconds

            $urlRouterProvider.otherwise("/admin/start");

            //make sure laravel request->ajax() still works
            $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

            //add a hard reload when csrf token mismatches
            $httpProvider.interceptors.push('csrfHandler');
            $httpProvider.interceptors.push('authHandler');

            $ocLazyLoadProvider.config({
                // Set to true if you want to see what and when is dynamically loaded
                debug: false
            });

            $locationProvider.html5Mode(true);

            $stateProvider

                .state('admin', {
                    abstract: true,
                    url: "/admin",
                    templateUrl: "templates/admin/layout/content",
                })
                .state('admin.start', {
                    url: "/start",
                    templateUrl: "templates/admin/start",
                    resolve: {
                        loadPlugin: function ($ocLazyLoad) {
                            //return $ocLazyLoad.load([
                            //    {
                            //
                            //        serie: true,
                            //        name: 'angular-flot',
                            //        files: ['js/admin/plugins/flot/jquery.flot.js', 'js/admin/plugins/flot/jquery.flot.time.js', 'js/admin/plugins/flot/jquery.flot.tooltip.min.js', 'js/admin/plugins/flot/jquery.flot.spline.js', 'js/admin/plugins/flot/jquery.flot.resize.js', 'js/admin/plugins/flot/jquery.flot.pie.js', 'js/admin/plugins/flot/curvedLines.js', 'js/admin/plugins/flot/angular-flot.js',]
                            //    },
                            //    {
                            //        name: 'angles',
                            //        files: ['js/admin/plugins/chartJs/angles.js', 'js/admin/plugins/chartJs/Chart.min.js']
                            //    },
                            //    {
                            //        name: 'angular-peity',
                            //        files: ['js/admin/plugins/peity/jquery.peity.min.js', 'js/admin/plugins/peity/angular-peity.js']
                            //    }
                            //]);
                        }
                    }
                });
        })
        .run(function ($rootScope, $state, System, $translate) {
            $rootScope.$state = $state;

            $rootScope.$on('$stateChangeStart',
                function (event, toState, toParams, fromState, fromParams) {

                    //make sure users need to select their locale.
                    System.then(function () {
                        if (!System.user.locale_id && toState.name != 'admin.profile') {
                            $state.go('admin.profile');
                            event.preventDefault();
                        }

                        if(System.user.locale_id)
                        {
                            $translate.use(System.user.locale.slug);
                        }
                    });

                })
        });


})(window.Pace);
