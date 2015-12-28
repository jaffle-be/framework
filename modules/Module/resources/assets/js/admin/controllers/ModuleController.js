(function () {
    'use strict';

    angular.module('module')
        .controller('ModuleController', function (Module, System) {
            this.options = {};
            var me = this;

            System.then(function(){
                me.options = System.options;
            });

            this.save = function (module) {
                Module.toggle(module);
            };

        });

})();
