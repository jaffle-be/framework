angular.module('contact')
    .directive('socialLinksInput', function (SocialLinks, $timeout) {
        return {
            restrict: 'A',
            templateUrl: 'templates/admin/contact/social-links/widget',
            scope: {
                ownerType: '=',
                ownerId: '='
            },
            controller: function ($scope) {

                var timeout;

                function load() {
                    SocialLinks.find({
                        ownerType: $scope.ownerType,
                        ownerId: $scope.ownerId,
                    }).$promise.then(function (links) {
                            $scope.links = links
                        });
                }

                this.save = function()
                {
                    if(timeout)
                    {
                        $timeout.cancel(timeout);
                    }

                    timeout = $timeout(function(){
                        $scope.links.$update({
                            ownerType: $scope.ownerType,
                            ownerId: $scope.ownerId
                        });
                    }, 400);

                };

                load();
            },
            controllerAs: 'vm',
        };
    });