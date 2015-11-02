(function () {
    'use strict';

    angular
        .module('system')
        .directive('autoSize', function () {
            return {
                restrict: 'A',
                link: function (scope, element) {
                    if (element[0])
                    {
                        element.on('focus', function () {
                            autosize.update(element[0]);
                        });

                        autosize(element[0]);
                    }
                }
            }
        });

})();