(function () {
    'use strict';

    angular.module('module')
        .controller('ModuleController', function (Module, System) {
            this.options = {};
            var me = this;

            this.save = function (module) {
                Module.toggle(module);
            };

        });

})();
