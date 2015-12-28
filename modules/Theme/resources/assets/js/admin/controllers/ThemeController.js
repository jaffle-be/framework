(function () {
    'use strict';

    angular.module('theme')
        .controller('ThemeController', function (ThemeService, Theme, $window, System) {
            this.options = {};
            this.themes = [];
            this.theme = false;

            var me = this;

            ThemeService.list(function (themes) {
                me.themes = themes;
                for (var i = 0; i < themes.length; i++) {
                    if (themes[i].active) {
                        me.theme = themes[i];
                    }
                }
            });

            this.activate = function () {
                ThemeService.activate(this.theme, function (response) {
                    if (response.data.status == 'oke') {
                        $window.location.reload();
                    }
                    else {
                        me.failed = true;
                    }

                });
            }
        });

})();
