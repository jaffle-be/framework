angular.module('portfolio')
    .controller('PortfolioDetailController', function (Portfolio, PortfolioService, MembershipService, Client, $state) {

        this.projects = PortfolioService;
        this.memberships = [];
        this.collaborators = [];
        this.clients = [];

        var me = this,
            id = $state.params.id;


        this.load = function(id){

            if(id)
            {
                this.projects.find(id, function(project){
                    me.project = project;

                    PortfolioService.collaborators(me.project, function(response){
                        me.collaborators = response;
                    });
                });
            }
            else{
                me.project = new Portfolio();
                me.collaborators = [];
            }

            MembershipService.list(function(response){
                me.memberships = response;
            });

            Client.list({}, function(clients){
                me.clients = clients;
            });
        };

        this.save = function()
        {
            PortfolioService.save(me.project);
        };

        this.toggleCollaboration = function(collaborator)
        {
            PortfolioService.toggleCollaboration(me.project, collaborator);
        };

        this.load(id);

    });