(function () {
    'use strict';

    angular.module('system').directive('ngConfirm', ['$modal', '$translate',
        function ($modal, $translate) {

            var ModalInstanceCtrl = function ($scope, $modalInstance) {
                $scope.ok = function () {
                    $modalInstance.close();
                };

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
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

                            var modalInstance = $modal.open({
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