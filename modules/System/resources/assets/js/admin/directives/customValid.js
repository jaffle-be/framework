(function () {
    'use strict';


    /**
     * customValid - Directive for custom validation example
     */
    function customValid() {
        return {
            require: 'ngModel',
            link: function (scope, ele, attrs, c) {
                scope.$watch(attrs.ngModel, function () {

                    // You can call a $http method here
                    // Or create custom validation

                    var validText = "Inspinia";

                    if (scope.extras == validText) {
                        c.$setValidity('cvalid', true);
                    } else {
                        c.$setValidity('cvalid', false);
                    }

                });
            }
        }
    }


    angular
        .module('system')
        .directive('customValid', customValid);

})();