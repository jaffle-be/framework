(function () {
    'use strict';

//when the token is missing, we do a hard reload, so the token is there!
    function csrfHandler($window, $q) {
        return {
            responseError: function (response) {
                //if the response is a 403 we will do a hard reload.
                if (response.status === 403)
                {
                    $window.location.reload();
                }

                return $q.reject(response);
            }
        }
    }

    angular.module('system')
        .factory('csrfHandler', csrfHandler);

})();