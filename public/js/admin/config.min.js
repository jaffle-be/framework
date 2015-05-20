function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider, IdleProvider, KeepaliveProvider) {

    // Configure Idle settings
    IdleProvider.idle(5); // in seconds
    IdleProvider.timeout(120); // in seconds

    $urlRouterProvider.otherwise("/dashboard/start");

    $ocLazyLoadProvider.config({
        // Set to true if you want to see what and when is dynamically loaded
        debug: false
    });

    $stateProvider

        .state('dashboard', {
            abstract: true,
            url: "/dashboard",
            templateUrl: "admin/templates/content",
        })
        .state('dashboard.start', {
            url: "/start",
            templateUrl: "views/dashboard_1.html",
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {

                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/admin/plugins/flot/jquery.flot.js', 'js/admin/plugins/flot/jquery.flot.time.js', 'js/admin/plugins/flot/jquery.flot.tooltip.min.js', 'js/admin/plugins/flot/jquery.flot.spline.js', 'js/admin/plugins/flot/jquery.flot.resize.js', 'js/admin/plugins/flot/jquery.flot.pie.js', 'js/admin/plugins/flot/curvedLines.js', 'js/admin/plugins/flot/angular-flot.js', ]
                        },
                        {
                            name: 'angles',
                            files: ['js/admin/plugins/chartJs/angles.js', 'js/admin/plugins/chartJs/Chart.min.js']
                        },
                        {
                            name: 'angular-peity',
                            files: ['js/admin/plugins/peity/jquery.peity.min.js', 'js/admin/plugins/peity/angular-peity.js']
                        }
                    ]);
                }
            }
        })
        .state('dashboard.widgets', {
            url: "/widgets",
            templateUrl: "views/widgets.html",
            data: { pageTitle: 'Widhets' },
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            name: 'angular-flot',
                            files: [ 'js/admin/plugins/flot/jquery.flot.js', 'js/admin/plugins/flot/jquery.flot.time.js', 'js/admin/plugins/flot/jquery.flot.tooltip.min.js', 'js/admin/plugins/flot/jquery.flot.spline.js', 'js/admin/plugins/flot/jquery.flot.resize.js', 'js/admin/plugins/flot/jquery.flot.pie.js', 'js/admin/plugins/flot/curvedLines.js', 'js/admin/plugins/flot/angular-flot.js', ]
                        },
                        {
                            files: ['css/admin/plugins/iCheck/custom.css','js/admin/plugins/iCheck/icheck.min.js']
                        },
                        {
                            files: ['js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js','js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js']
                        },
                        {
                            name: 'ui.checkbox',
                            files: ['js/admin/bootstrap/angular-bootstrap-checkbox.js']
                        }
                    ]);
                }
            }
        })
}
angular
    .module('app')
    .config(config)
    .run(function($rootScope, $state) {
        $rootScope.$state = $state;
    });
