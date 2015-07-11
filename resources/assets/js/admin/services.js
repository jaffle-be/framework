function csrfHandler($window, $q)
{
    return {
        responseError: function(response)
        {
            //if the response is a 403 we will do a hard reload.
            if(response.status === 403)
            {
                $q.reject(response);
                $window.location.reload();
            }

            return $q.reject(response);
        }
    }
}

angular.module('app')
    .factory('csrfHandler', csrfHandler);