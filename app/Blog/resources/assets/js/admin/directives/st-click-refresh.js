angular.module('smart-table')
    .directive('stClickRefresh', function ($timeout) {
        return {
            restrict: 'AE',
            require: '^stTable',
            link: function (scope, element, attrs, ctrl) {
                var table = ctrl.tableState();
                element.on('click', function (ev) {
                    ctrl.search('', 'query');
                });
            }
        }
    });