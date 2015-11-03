(function () {
    'use strict';

    angular.module('portfolio')
        .controller('PortfolioController', function (Portfolio, PortfolioService, $state, $scope, $sce) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.projects = [];

            var me = this;

            this.getPage = function (start) {
                return Math.ceil(start / this.rpp) + 1;
            };

            this.list = function (table) {

                me.table = table;
                me.loading = true;
                //cannot use this here
                var page = me.getPage(table.pagination.start);

                me.loadProjects(page);
            };

            this.loadProjects = function (page) {
                var me = this;

                Portfolio.query({
                    page: page,
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {

                    me.total = response.total;
                    me.projects = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.newProject = function () {
                var project = new Portfolio();
                PortfolioService.save(project, function (newProject) {
                    $state.go('admin.portfolio.detail', {id: newProject.id});
                });
            };

            this.delete = function () {
                var projects = this.selectedProjects();

                PortfolioService.batchDelete(projects, function () {
                    me.loadProjects();
                });

            };

            this.batchPublish = function () {
                var projects = this.selectedProjects();

                PortfolioService.batchPublish(projects, me.options.locale, function () {

                });
            };

            this.batchUnpublish = function () {
                var projects = this.selectedProjects();

                PortfolioService.batchUnpublish(projects, me.options.locale, function () {

                });
            };

            this.selectedProjects = function () {
                var projects = [],
                    me = this;

                _.each(this.projects, function (project) {
                    if (project.isSelected)
                    {
                        projects.push(project.id);
                    }
                });

                return projects;
            }
        });

})();