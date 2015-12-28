(function () {
    'use strict';

    angular.module('system').directive('ngConfirm', confirmation);

    confirmation.$inject = ['$uibModal'];
    function confirmation($uibModal) {

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
                ngConfirm: "&"
            },
            link: function (scope, element, attrs) {
                element.bind('click', function () {

                    var modalInstance = $uibModal.open({
                        templateUrl: 'confirmModal.html',
                        controller: ModalInstanceCtrl,
                        animation: false,
                        animate: false
                    });

                    modalInstance.result.then(function () {
                        scope.ngConfirm();
                    }, function () {
                        //Modal dismissed
                    });

                });

            }
        }
    };

})();
