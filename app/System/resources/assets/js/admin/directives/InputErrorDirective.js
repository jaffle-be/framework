angular.module('system').directive('inputErrors', function(){

    return {
        restrict: 'E',
        replace: true,
        template: function(element, attributes){
            return '<ul class="errors"><li ng-repeat="error in errors">{{ error[0]}}</li></div>';
        }
    }
});