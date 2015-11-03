(function () {
    'use strict';

    angular.module('system').directive('ngConfirm', ['$uibModal', '$translate',
        function ($uibModal, $translate) {

            var ModalInstanceCtrl = function ($scope, $uibModalInstance) {
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

                        $translate('CONFIRM').then(function (translation) {

                            scope.ngReallyMessage = 'Are you sure?';

                            var modalHtml = '<div class="modal-body">' + scope.ngReallyMessage + '</div>';
                            modalHtml += '<div class="modal-footer"><button class="btn btn-warning" ng-click="ok()">{{ "DO" | translate }}</button><button class="btn btn-default" ng-click="cancel()">{{ "CANCEL" | translate }}</button></div>';

                            var modalInstance = $uibModal.open({
                                template: modalHtml,
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

                    });

                }
            }
        }]);

})();