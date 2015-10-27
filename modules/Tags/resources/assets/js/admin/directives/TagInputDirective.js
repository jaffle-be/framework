angular.module('tags')
    .directive('tagInput', function (TagService) {

        return {
            restrict: 'E',
            templateUrl: 'templates/admin/tag/widget',
            scope: {
                ownerType: '=',
                ownerId: '=',
                locale: '=',
            },
            controller: function ($scope) {
                $scope.input = '';
                $scope.tags = [];
                $scope.ctrl = this;

                this.updateTag = function (tag) {
                    TagService.update($scope.ownerType, $scope.ownerId, tag);
                };

                this.deleteTag = function (tag) {
                    TagService.delete($scope.ownerType, $scope.ownerId, tag, _.remove($scope.tags, function (value, index, array) {
                        return value.id == tag.id
                    }));
                };

                this.searchTag = function (value) {
                    return TagService.search($scope.ownerType, $scope.ownerId, $scope.locale, value).then(function (response) {
                        return response.data;
                    });
                };

                this.createTag = function () {
                    TagService.create($scope.ownerType, $scope.ownerId, $scope.locale, $scope.input, function (tag) {
                        $scope.tags.push(tag);
                        $scope.input = '';
                    });
                };

                this.addTag = function ($item, $model, $label) {
                    TagService.link($scope.ownerType, $scope.ownerId, $item, function (response) {
                        $scope.tags.push(response);
                        $scope.input = "";
                    });
                };

                //only load when we're working on an existing document.
                if($scope.ownerId)
                {
                    TagService.list($scope.ownerType, $scope.ownerId, function (response) {
                        $scope.tags = response;
                    });
                }
            }
        }

    });