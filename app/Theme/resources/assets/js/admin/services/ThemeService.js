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
            saveSelect: function(theme, setting, option)
            {
                return $http.post('api/admin/theme/'+ theme.id + '/setting/' + setting.id, {
                    option: option.id,
                });
            },
            saveCheckbox: function(theme, setting, checked)
            {
                return $http.post('api/admin/theme/'+ theme.id + '/setting/' + setting.id, {
                    checked: checked
                });
            }
        };

    });