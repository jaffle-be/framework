(function () {
    'use strict';


    /**
     * pageTitle - Directive for set Page title - mata title
     */
    function pageTitle($rootScope, $timeout) {
        return {
            link: function (scope, element) {
                var listener = function (event, toState, toParams, fromState, fromParams) {
                    // Default title - load on Dashboard 1
                    var title = 'INSPINIA | Responsive Admin Theme';
                    // Create your own title pattern
                    if (toState.data && toState.data.pageTitle) title = 'INSPINIA | ' + toState.data.pageTitle;
                    $timeout(function () {
                        element.text(title);
                    });
                };
                $rootScope.$on('$stateChangeStart', listener);
            }
        }
    };

    angular
        .module('system')
        .directive('pageTitle', pageTitle)

})();