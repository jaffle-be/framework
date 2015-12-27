(function () {
    'use strict';

    angular.module('system').directive('ngReally', really);

    really.$inject = ['$uibModal', '$translate'];

    function really($uibModal, $translate) {

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

                    $translate('CONFIRM').then(function (translation) {

                        if (!scope.ngReallyMessage) {
                            if (translation) {
                                scope.ngReallyMessage = translation;
                            }
                            else {
                                scope.ngReallyMessage = 'Are you sure?';
                            }
                        }

                        var modalHtml = '<div class="modal-body">' + scope.ngReallyMessage + '</div>';
                        modalHtml += '<div class="modal-footer"><button class="btn btn-danger" ng-click="ok()">{{ "REMOVE" | translate }}</button><button class="btn btn-default" ng-click="cancel()">{{ "CANCEL" | translate }}</button></div>';

                        var modalInstance = $uibModal.open({
                            template: modalHtml,
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

                });

            }
        }
    }

})();