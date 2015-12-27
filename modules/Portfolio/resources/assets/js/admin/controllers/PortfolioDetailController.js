(function () {
    'use strict';

    angular.module('portfolio')
        .controller('PortfolioDetailController', function ($scope, Portfolio, PortfolioService, MembershipService, Client, $state, System) {
            this.options = System.options;
            this.projects = PortfolioService;
            this.memberships = [];
            this.collaborators = [];
            this.clients = [];
            $scope.status = {
                datepickerStatus: false
            };

            var me = this,
                id = $state.params.id;


            this.load = function (id) {

                if (id) {
                    this.projects.find(id, function (project) {
                        me.project = project;

                        PortfolioService.collaborators(me.project, function (response) {
                            me.collaborators = response;
                        });
                    });
                }
                else {
                    me.project = new Portfolio();
                    me.collaborators = [];
                }

                MembershipService.list(function (response) {
                    me.memberships = response;
                });

                Client.list({}, function (clients) {
                    me.clients = clients;
                });
            };

            this.save = function () {
                PortfolioService.save(me.project);
            };

            this.delete = function () {
                PortfolioService.delete(me.project, function () {
                    $state.go('admin.portfolio.overview');
                });
            };

            this.toggleCollaboration = function (collaborator) {
                PortfolioService.toggleCollaboration(me.project, collaborator);
            };

            this.openDatepicker = function ($event) {
                $scope.status.datepickerStatus = !$scope.status.datepickerStatus;
                $event.preventDefault();
                $event.stopPropagation();
            };

            this.load(id);

        });

})();
