angular.module('system').directive('ngReally', ['$modal', '$translate',
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
                ngReally: "&",
            },
            link: function (scope, element, attrs) {
                element.bind('click', function () {

                    $translate('CONFIRM').then(function (translation) {

                        if(!scope.ngReallyMessage)
                        {
                            if(translation)
                            {
                                scope.ngReallyMessage = translation;
                            }
                            else {
                                scope.ngReallyMessage = 'Are you sure?';
                            }
                        }

                        var modalHtml = '<div class="modal-body">' + scope.ngReallyMessage  + '</div>';
                        modalHtml += '<div class="modal-footer"><button class="btn btn-danger" ng-click="ok()">{{ "REMOVE" | translate }}</button><button class="btn btn-default" ng-click="cancel()">{{ "CANCEL" | translate }}</button></div>';

                        var modalInstance = $modal.open({
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
    }]);