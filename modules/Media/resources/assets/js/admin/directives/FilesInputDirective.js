(function () {
    'use strict';

    angular.module('media')
        .directive('fileInput', function () {

            return {
                restrict: 'E',
                templateUrl: 'templates/admin/media/file/widget',
                scope: {
                    locale: '=',
                    ownerId: '=',
                    ownerType: '=',
                },
                controller: function ($scope, FileResource, FileService, toaster) {
                    var me = this;
                    //init base variables and dropzone
                    $scope.loaded = false;
                    $scope.ctrl = this;

                    this.sortables = {
                        orderChanged: function () {
                            FileService.sort($scope.ownerType, $scope.ownerId, me.files[$scope.locale]);
                        }
                    };

                    this.dropzone = function () {

                        $scope.dropzone = FileService.uploader($scope.ownerType, $scope.ownerId, $scope.locale, {
                            success: function (file, object, xhr) {
                                object = new FileResource(object);
                                if (!me.files[$scope.locale])
                                {
                                    me.files[$scope.locale] = [];
                                }
                                me.files[$scope.locale].push(object);
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
                            }
                        });
                    };

                    this.dropzone();


                    this.updateFile = function (file) {
                        FileService.update($scope.ownerType, $scope.ownerId, file);
                    };

                    this.deleteFile = function (file) {
                        FileService.delete($scope.ownerType, $scope.ownerId, file, function () {
                            _.remove(me.files[$scope.locale], function (value, index, array) {
                                return value.id == file.id;
                            });
                        });
                    };

                    this.init = function () {
                        FileService.list($scope.ownerType, $scope.ownerId, function (response) {
                            me.files = response.data;
                            $scope.loaded = true;
                        });
                    };

                    this.init();
                }

            }


        });
})();