angular.module('portfolio')
.factory('PortfolioService', function(Portfolio, $timeout, $http){

        return Service = {
            find: function(id, success)
            {
                Portfolio.get({id: id}, success);
            },
            query: function(params, success)
            {
                Portfolio.query(params, success);
            },
            save: function(project, success)
            {
                if(project.id)
                {
                    if(this.timeout)
                    {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function()
                    {
                        return project.$update(success);
                    }, 400);
                }
                else{
                    project.$save({}, success);
                }
            },
            collaborators: function(project, success)
            {
                Portfolio.collaborators({
                    id: project.id
                }, success);
            },
            toggleCollaboration: function(project, collaborator, success)
            {
                Portfolio.toggleCollaboration({
                    id: project.id,
                }, {
                    member: collaborator.id,
                    status: collaborator.selected
                },success);
            },
            delete: function(project, success)
            {
                project.$delete().then(success);
            },
            batchDelete: function(projects, success)
            {
                $http.post('/api/admin/portfolio/batch-delete', {
                    projects: projects
                }).then(success);
            }

        };

    });