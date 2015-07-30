angular.module('theme')
    .factory('ThemeService', function(Theme, $http) {

        return {
            list: function(success)
            {
                return Theme.list(success);
            },
            activate: function(theme, success)
            {
                return $http.post('api/admin/theme/' + theme.id + '/activate', {}).then(success);
            },
            current: function(success)
            {
                Theme.current(success);
            },
            saveSetting: function(theme, option)
            {
                return $http.post('api/admin/theme/'+ theme.id + '/setting', {
                    option: option.id,
                });
            }
        };

    });