(function () {
    'use strict';

    function closeOffCanvas() {
        return {
            restrict: 'A',
            template: '<a class="close-canvas-menu" ng-click="closeOffCanvas()"><i class="fa fa-times"></i></a>',
            controller: function ($scope, $element) {
                $scope.closeOffCanvas = function () {
                    $("body").toggleClass("mini-navbar");
                }
            }
        };
    }

    angular
        .module('system')
        .directive('closeOffCanvas', closeOffCanvas);

})();