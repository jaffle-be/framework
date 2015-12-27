(function () {
    'use strict';

    angular.module('portfolio')
        .factory('PortfolioService', function (Portfolio, $timeout, $http) {

            return {
                find: function (id, success) {
                    Portfolio.get({id: id}, success);
                },
                query: function (params, success) {
                    Portfolio.query(params, success);
                },
                save: function (project, success) {
                    if (project.id) {
                        //use a copy, so the response will not reset the form to the last saved instance while typing.
                        var destination = angular.copy(project);

                        if (this.timeout) {
                            $timeout.cancel(this.timeout);
                        }

                        this.timeout = $timeout(function () {
                            return destination.$update(success);
                        }, 400);
                    }
                    else {
                        project.$save({}, success);
                    }
                },
                collaborators: function (project, success) {
                    Portfolio.collaborators({
                        id: project.id
                    }, success);
                },
                toggleCollaboration: function (project, collaborator, success) {
                    Portfolio.toggleCollaboration({
                        id: project.id,
                    }, {
                        member: collaborator.id,
                        status: collaborator.selected
                    }, success);
                },
                delete: function (project, success) {
                    project.$delete().then(success);
                },
                batchDelete: function (projects, success) {
                    $http.post('/api/admin/portfolio/batch-delete', {
                        projects: projects
                    }).then(success);
                },
                batchPublish: function (projects, locale, success) {
                    $http.post('/api/admin/portfolio/batch-publish', {
                        projects: projects,
                        locale: locale
                    }).then(success);
                },
                batchUnpublish: function (projects, locale, success) {
                    $http.post('/api/admin/portfolio/batch-unpublish', {
                        projects: projects,
                        locale: locale
                    }).then(success);
                },

            };

        });

})();