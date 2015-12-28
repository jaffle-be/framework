(function () {
    'use strict';

    angular.module('system').directive('ngReally', really);

    really.$inject = ['$uibModal'];
    function really($uibModal) {

        ModalInstanceCtrl.$inject = ['$scope', '$uibModalInstance'];

        function ModalInstanceCtrl($scope, $uibModalInstance) {
            $scope.ok = function () {
                $uibModalInstance.close();
            };

            $scope.cancel = function () {
                $uibModalInstance.dismiss('cancel');
            };
        };

        return {
            restrict: 'A',
            scope: {
                ngReally: "&",
            },
            link: function (scope, element, attrs) {
                element.bind('click', function () {

                    var modalInstance = $uibModal.open({
                        templateUrl: 'reallyModal.html',
                        controller: ModalInstanceCtrl,
                        animation: false,
                        animate: false
                    });

                    modalInstance.result.then(function () {
                        scope.ngReally();
                    }, function () {
                        //Modal dismissed
                    });

                });

            }
        }
    }

})();
