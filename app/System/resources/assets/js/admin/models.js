angular.module('system')
    .factory('Locale', function($http)
    {
        return {
            toggle: function(locale)
            {
                $http.post('api/admin/system/locale', locale);
            }
        }
    });