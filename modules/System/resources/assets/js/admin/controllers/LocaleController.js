(function () {
    'use strict';

    angular.module('system')
        .controller('LocaleController', function (Locale, System) {
            this.options = {};
            var me = this;

            System.then(function(){
                me.options = System.options;
            });

            this.save = function (locale) {
                Locale.toggle(locale);
            };

        });

})();
