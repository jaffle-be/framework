angular.module('system')
    .directive('seoInput', function (SeoService) {

        return {
            restrict: 'E',
            templateUrl: 'templates/admin/seo/widget',
            scope: {
                ownerType: '=',
                ownerId: '=',
                locale: '=',
            },
            controller: function ($scope) {
                $scope.input = '';
                $scope.seo = {};
                $scope.seo[$scope.locale] = [];
                $scope.ctrl = this;

                this.updateSeo = function () {
                    SeoService.update($scope.ownerType, $scope.ownerId, $scope.locale, $scope.seo[$scope.locale]);
                };

                //only load when we're working on an existing document.
                if($scope.ownerId)
                {
                    SeoService.list($scope.ownerType, $scope.ownerId, $scope.locale, function (response) {
                        $scope.seo = response.data;
                    });
                }
            }
        }

    });