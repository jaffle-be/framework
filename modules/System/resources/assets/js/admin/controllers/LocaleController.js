(function () {
    'use strict';

    angular.module('system')
        .controller('LocaleController', function (Locale) {
            this.save = function (locale) {
                Locale.toggle(locale);
            };

        });

})();