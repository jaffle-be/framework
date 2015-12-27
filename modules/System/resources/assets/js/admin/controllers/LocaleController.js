(function () {
    'use strict';

    angular.module('system')
        .controller('LocaleController', function (Locale, System) {
            this.options = System.options;
            this.save = function (locale) {
                Locale.toggle(locale);
            };

        });

})();
