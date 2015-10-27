angular.module('theme')
    .factory('ThemeService', function(Theme, $http, $timeout) {

        return {
            timeouts : [],
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
            },
            delayedSave: function(theme, setting, value)
            {
                if(this.timeouts[setting.id])
                {
                    $timeout.cancel(this.timeouts[setting.id]);
                }

                this.timeouts[setting.id] = $timeout(function()
                {
                    return $http.post('api/admin/theme/'+ theme.id + '/setting/' + setting.id, value);

                }, 400);
            }
        };

    });