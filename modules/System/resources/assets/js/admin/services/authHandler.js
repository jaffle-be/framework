function authHandler($window, $q) {
    return {
        responseError: function (response) {
            if (response.status === 401)
            {
                $window.location.href = '/auth/signin';
            }

            return $q.reject(response);
        }
    }
}

angular.module('system')
    .factory('authHandler', authHandler)

    //this is needed to ensure we do redirect to signin page when we're going to /admin (instead of a specific page like /admin/start)
    //the ui-router would freak out and go into a redirection loop to admin/start, but that page would return the 401, and then another request is made
    //up untill some shady moment where the browser does redirect to the signin page. (mostly this happend right when opening developer tools)
    .run(function ($rootScope, $window) {
        $rootScope.$on('$stateChangeError',
            function (event, toState, toParams, fromState, fromParams, error) {
                if (error.status === 401)
                {
                    $window.location.href = '/auth/signin';
                    event.preventDefault();
                }
            });
    });