angular.module('media')
    .directive('imageInput', function () {

        return {
            restrict: 'E',
            templateUrl: 'templates/admin/media/image/widget',
            scope: {
                locale: '=',
                ownerId: '=',
                ownerType: '=',
                waitFor: '=?',
                titles: '=?',
                limit: '=?',
                editsMany: '=?',
                handlers: '=?',
            },
            controller: function ($scope, Image, ImageService, toaster) {
                var me = this;
                //init base variables and dropzone
                $scope.loaded = false;
                $scope.ctrl = this;

                if($scope.handlers === undefined)
                {
                    $scope.handlers = {}
                };

                if ($scope.editsMany === undefined)
                {
                    $scope.editsMany = false;
                }

                if ($scope.limit)
                {
                    $scope.locked = true;
                    $scope.$watch('images.length', function (newValue, oldValue) {

                        if (newValue >= $scope.limit)
                        {
                            $scope.locked = true;
                        }
                        else
                        {
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

                            if(typeof $scope.handlers.uploadedImage === 'function')
                            {
                                $scope.handlers.uploadedImage(img);
                            }

                            this.removeFile(file);
                            $scope.$apply();
                        },
                        processing: function () {
                            this.options.params.ownerId = $scope.ownerId;
                        },
                        addedfile: function(file){

                            if($scope.images.length >= $scope.limit)
                            {
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

                        if(typeof $scope.handlers.deletedImage === 'function')
                        {
                            $scope.handlers.deletedImage(img);
                        }
                    });
                };

                this.init = function () {
                    ImageService.list($scope.ownerType, $scope.ownerId, function (response) {
                        $scope.images = response;
                        $scope.loaded = true;
                    });
                };

                //only load when we're working on an existing document
                if ($scope.waitFor !== undefined)
                {
                    $scope.$watch('waitFor', function (newValue, oldValue) {
                        //only trigger if value changed from something false to something true.

                        if (newValue)
                        {
                            me.init();
                        }
                    });
                }
                else if ($scope.ownerId)
                {
                    this.init();
                }

                if ($scope.editsMany)
                {
                    $scope.$watch('ownerId', function (newValue, oldValue) {

                        if (newValue)
                        {
                            me.loaded = false;
                            me.init();
                        }
                    });
                }
            }

        }


    });