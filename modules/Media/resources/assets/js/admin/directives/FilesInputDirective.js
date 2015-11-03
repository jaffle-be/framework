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
                    files: '=',
                },
                controllerAs: 'vm',
                controller: function ($scope, FileResource, FileService, toaster) {
                    var me = this;
                    //init base variables and dropzone
                    $scope.loaded = true;
                    $scope.ctrl = this;
                    $scope.dropzone = initDropzone();

                    this.updateFile = updateFile;
                    this.deleteFile = deleteFile;
                    this.init = init;

                    this.sortables = {
                        orderChanged: function () {
                            FileService.sort($scope.ownerType, $scope.ownerId, $scope.files[$scope.locale]);
                        }
                    };

                    $scope.$watch('files', function (newValue) {

                        if (newValue)
                        {
                            $scope.dupes = newValue;
                        }
                    });

                    function initDropzone() {

                        return FileService.uploader($scope.ownerType, $scope.ownerId, $scope.locale, {
                            success: dropzoneSuccess,
                            error: dropzoneError,
                            processing: dropzoneProcessing
                        });
                    };

                    function dropzoneSuccess(file, object, xhr) {
                        object = new FileResource(object);
                        if (!$scope.files[$scope.locale])
                        {
                            $scope.files[$scope.locale] = [];
                        }
                        $scope.files[$scope.locale].push(object);
                        this.removeFile(file);
                        $scope.$apply();
                    };

                    function dropzoneError(file, message, response) {
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
                    };

                    function dropzoneProcessing() {
                        this.options.params.ownerId = $scope.ownerId;
                        this.options.params.locale = $scope.locale;
                    };

                    function init() {
                        FileService.list($scope.ownerType, $scope.ownerId, function (response) {
                            $scope.files = response.data;
                            $scope.loaded = true;
                        });
                    };

                    function updateFile(file) {
                        FileService.update($scope.ownerType, $scope.ownerId, file);
                    };

                    function deleteFile(file) {
                        FileService.delete($scope.ownerType, $scope.ownerId, file, function () {
                            _.remove($scope.files[$scope.locale], function (value, index, array) {
                                return value.id == file.id;
                            });
                        });
                    };
                }

            }


        });
})();