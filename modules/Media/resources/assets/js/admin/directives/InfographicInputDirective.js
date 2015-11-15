(function () {
    'use strict';

    angular.module('media')
        .directive('infographicInput', function () {

            return {
                restrict: 'E',
                templateUrl: 'templates/admin/media/infographic/widget',
                scope: {
                    locale: '=',
                    ownerId: '=',
                    ownerType: '=',
                    graphics: '=infographics',
                },
                controllerAs: 'vm',
                controller: function ($scope, InfographicResource, InfographicService, toaster) {
                    var me = this;
                    //init base variables and dropzone
                    $scope.loaded = true;

                    this.dropzone = function () {

                        $scope.dropzone = InfographicService.uploader($scope.ownerType, $scope.ownerId, $scope.locale, {
                            success: function (file, graphic, xhr) {
                                graphic = new InfographicResource(graphic);
                                if ($scope.graphics[$scope.locale] === undefined)
                                {
                                    $scope.graphics[$scope.locale] = [];
                                }

                                $scope.graphics[$scope.locale].push(graphic);
                                this.removeFile(file);
                                $scope.$apply();
                            },
                            error: function (file, message, response) {
                                //added to avoid large popup when we try uploading a file which is too large
                                if (response.status == 413)
                                {
                                    toaster.error(response.statusText);
                                }
                                else
                                {
                                    toaster.error(message);
                                }

                                this.removeFile(file);
                                $scope.$apply();
                            },
                            processing: function () {
                                this.options.params.ownerId = $scope.ownerId;
                                this.options.params.locale = $scope.locale;
                            },
                        });
                    };

                    this.dropzone();


                    this.updateInfographic = function (graphic) {
                        InfographicService.update($scope.ownerType, $scope.ownerId, graphic);
                    };

                    this.deleteInfographic = function (graphic) {
                        InfographicService.delete($scope.ownerType, $scope.ownerId, graphic, function () {
                            _.remove($scope.graphics[$scope.locale], function (value, index, array) {
                                return value.id == graphic.id;
                            });
                        });
                    };

                    //move up means lower index
                    this.moveUp = function (graphic, index) {
                        if (index - 1 >= 0)
                        {
                            $scope.graphics[$scope.locale][index] = $scope.graphics[$scope.locale][index - 1];
                            $scope.graphics[$scope.locale][index - 1] = graphic;
                            InfographicService.sort($scope.ownerType, $scope.ownerId, $scope.graphics[$scope.locale]);
                        }
                    };

                    //move down means higher index
                    this.moveDown = function (graphic, index) {
                        if (index + 1 <= $scope.graphics[$scope.locale].length - 1)
                        {
                            $scope.graphics[$scope.locale][index] = $scope.graphics[$scope.locale][index + 1];
                            $scope.graphics[$scope.locale][index + 1] = graphic;
                            InfographicService.sort($scope.ownerType, $scope.ownerId, $scope.graphics[$scope.locale]);
                        }
                    };

                    this.init = function () {
                        InfographicService.list($scope.ownerType, $scope.ownerId, function (response) {
                            $scope.graphics = response.data;
                            $scope.loaded = true;
                        });
                    };
                }

            }


        });

})();