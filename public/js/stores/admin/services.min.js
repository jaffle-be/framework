function csrfHandler($window)
{
    return {
        responseError: function(response)
        {
            //if the response is a 403 we will do a hard reload.
            if(response.status === 403)
            {
                $window.location.reload();
            }
        }
    }
}

angular.module('app')
    .factory('csrfHandler', csrfHandler)