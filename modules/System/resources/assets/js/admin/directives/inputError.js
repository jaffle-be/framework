(function () {
    'use strict';

    angular.module('system').directive('inputErrors', function () {

        return {
            restrict: 'E',
            replace: true,
            scope: {
                errors: '='
            },
            template: function (element, attributes) {
                return '<ul class="errors"><li ng-repeat="error in errors">{{ error[0]}}</li></div>';
            }
        }
    });

})();