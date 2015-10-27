angular.module('module')
    .controller('ModuleController', function(Module)
    {
        this.save = function(module)
        {
            Module.toggle(module);
        };

    });