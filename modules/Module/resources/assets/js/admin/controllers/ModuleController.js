(function () {
    'use strict';

    angular.module('module')
        .controller('ModuleController', function (Module, System) {
            this.options = System.options;

            this.save = function (module) {
                Module.toggle(module);
            };

        });

})();
