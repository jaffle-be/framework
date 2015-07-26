angular.module('portfolio')
.factory('PortfolioService', function(Portfolio, $timeout){

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
            }

        };

    });