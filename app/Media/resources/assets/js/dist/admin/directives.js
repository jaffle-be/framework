angular.module('media')
    .directive('imageInput', function () {

        return {
            restrict: 'E',
            templateUrl: 'templates/admin/media/image/widget',
            scope: {
                locale: '=',
                ownerId: '=',
                ownerType: '=',
            },
            controller: function ($scope, Image, ImageService) {
                //init base variables and dropzone
                $scope.images = [];
                $scope.ctrl = this;
                $scope.dropzone = ImageService.uploader($scope.ownerType, $scope.ownerId, function (file, image, xhr) {
                    var img = new Image(image);
                    $scope.images.push(img);
                    this.removeFile(file);
                    $scope.$apply();
                });

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

                //only load when we're working on an existing document
                if($scope.ownerId)
                {
                    ImageService.list($scope.ownerType, $scope.ownerId, function (response) {
                        $scope.images = response;
                    });
                }

            }

        }


    });