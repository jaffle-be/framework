(function () {
    'use strict';

    angular.module('system')
        .controller('LocaleController', function (Locale, System) {
            this.options = {};
            var me = this;

            this.save = function (locale) {
                Locale.toggle(locale);
            };

        });

})();
