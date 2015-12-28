(function () {
    'use strict';

    angular.module('account')
        .controller('AccountContactController', function ($scope, $state, System, AccountContactInformation, $timeout, InputTranslationHandler) {
            var me = this;

            this.options = {};
            this.timer = false;

            this.load = function () {
                AccountContactInformation.load(function (response) {
                    me.info = response;
                });
            };

            this.save = function () {

                if (this.timer) {
                    $timeout.cancel(this.timer);
                }

                this.timer = $timeout(function () {

                    if (!me.info.id) {
                        me.info.$save(function () {
                            $scope.errors = [];
                        }, function (response) {
                            $scope.errors = response.data;
                        });
                    }
                    else {
                        //don't update UI with returned object
                        var info = angular.copy(me.info);

                        info.$update(function () {
                            $scope.errors = [];
                        }, function (response) {
                            $scope.errors = response.data;
                        });
                    }

                }, 400)
            };

            this.load();
        });

})();
