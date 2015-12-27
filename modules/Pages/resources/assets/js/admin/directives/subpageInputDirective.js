(function () {
    'use strict';

    angular.module('pages')
        .directive('subpageInput', function (PageService) {

            return {
                restrict: 'E',
                templateUrl: '/templates/admin/pages/widget',
                scope: {
                    locale: '=',
                    page: '=',
                },
                controller: function ($scope) {
                    var me = this;

                    $scope.vm = this;

                    this.parentPage = $scope.page;
                    this.locale = $scope.locale;

                    //need this to make sortable work.
                    //apparently, the plugin breaks when used within a directive with isolated scope.
                    $scope.$watch('page', function (newValue) {

                        if (newValue) {
                            me.parentPage = newValue;
                        }
                    });

                    this.sortables = {
                        orderChanged: function () {
                            PageService.sortSubpages(me.parentPage);
                        }
                    };

                    this.removePage = function (page) {
                        PageService.unlink(me.parentPage, page, function () {
                            _.remove(me.parentPage.children, function (value) {
                                return value.id == page.id
                            });

                            me.parentPage.availablePages.push(page);
                        });
                    };

                    this.addPage = function () {

                        var me = this;

                        PageService.link(me.parentPage, me.addingPage, function (response) {
                            me.parentPage.children.push(me.addingPage);
                            _.remove(me.parentPage.availablePages, function (page) {
                                return page.id == me.addingPage.id
                            });
                            me.addingPage = null;
                        });
                    };
                }
            }

        });

})();