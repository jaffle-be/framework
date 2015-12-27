(function () {
    'use strict';
    angular.module('media')
        .directive('imageInput', function () {

            return {
                restrict: 'E',
                templateUrl: 'templates/admin/media/image/widget',
                scope: {
                    locale: '=',
                    ownerId: '=',
                    ownerType: '=',
                    images: '=',
                    waitFor: '=?',
                    titles: '=?',
                    limit: '=?',
                },
                controllerAs: 'vm',
                controller: function ($scope, Image, ImageService, toaster) {
                    var me = this;
                    //init base variables and dropzone
                    $scope.loaded = true;

                    if ($scope.limit) {
                        $scope.locked = true;
                        $scope.$watch('images.length', function (newValue, oldValue) {

                            if (newValue >= $scope.limit) {
                                $scope.locked = true;
                            }
                            else {
                                $scope.locked = false;
                            }
                        });
                    }

                    this.dropzone = function () {

                        $scope.dropzone = ImageService.uploader($scope.ownerType, $scope.ownerId, $scope.limit, {
                            success: function (file, image, xhr) {
                                var img = new Image(image);
                                img.translations = {};
                                $scope.images.push(img);
                                this.removeFile(file);
                                $scope.$apply();
                            },
                            error: function (file, message, response) {
                                //added to avoid large popup when we try uploading a file which is too large
                                if (response.status == 413) {
                                    toaster.error(response.statusText);
                                }
                                else {
                                    toaster.error(message);
                                }
                                this.removeFile(file);
                                $scope.$apply();
                            },
                            processing: function () {
                                this.options.params.ownerId = $scope.ownerId;
                            },
                            addedfile: function (file) {
                                if (!$scope.images) {
                                    $scope.images = [];
                                }

                                if ($scope.images.length >= $scope.limit) {
                                    this.removeFile(file);
                                    toaster.pop('error', 'error uploading image', 'File limit reached');
                                    $scope.$apply();
                                }
                            }
                        });
                    };

                    this.dropzone();


                    this.updateImage = function (img) {
                        ImageService.update($scope.ownerType, $scope.ownerId, img);
                    };

                    this.deleteImage = function (img) {
                        ImageService.delete($scope.ownerType, $scope.ownerId, img, function () {
                            _.remove($scope.images, function (value, index, array) {
                                return value.id == img.id;
                            });
                        });
                    };

                    //move up means lower index
                    this.moveUp = function (img, index) {
                        if (index - 1 >= 0) {
                            $scope.images[index] = $scope.images[index - 1];
                            $scope.images[index - 1] = img;
                            ImageService.sort($scope.ownerType, $scope.ownerId, $scope.images);
                        }
                    };

                    //move down means higher index
                    this.moveDown = function (img, index) {
                        if (index + 1 <= $scope.images.length - 1) {
                            $scope.images[index] = $scope.images[index + 1];
                            $scope.images[index + 1] = img;
                            ImageService.sort($scope.ownerType, $scope.ownerId, $scope.images);
                        }
                    };

                    this.init = function () {
                        ImageService.list($scope.ownerType, $scope.ownerId, function (response) {
                            $scope.images = response;
                            $scope.loaded = true;
                        });
                    };
                }

            }


        });
})();