angular.module('pages')
    .directive('subpageInput', function (PageService) {

        return {
            restrict: 'E',
            templateUrl: '/templates/admin/pages/widget',
            scope: {
                ownerId: '=',
                locale: '=',
                page: '=',
            },
            controller: function ($scope) {
                $scope.vm = this;

                this.removePage = function (page) {
                    PageService.unlink($scope.page, page, function () {
                        _.remove($scope.page.children, function (value) {
                            return value.id == page.id
                        });

                        $scope.page.availablePages.push(page);
                    });
                };

                this.searchPage = function (value) {
                    return PageService.search($scope.ownerType, $scope.ownerId, $scope.locale, value).then(function (response) {
                        return response.data;
                    });
                };

                this.addPage = function () {

                    var me = this;

                    PageService.link($scope.page, me.addingPage, function (response) {
                        $scope.page.children.push(me.addingPage);
                        _.remove($scope.page.availablePages, function (page) {
                            return page.id == me.addingPage.id
                        });
                        me.addingPage = null;
                    });
                };

                //only load when we're working on an existing document.
                //if($scope.ownerId)
                //{
                //    PageService.list($scope.ownerType, $scope.ownerId, function (response) {
                //        $scope.children = response;
                //    });
                //}
            }
        }

    });