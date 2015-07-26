angular.module('portfolio')
    .controller('PortfolioDetailController', function (Portfolio, PortfolioService, $state) {

        this.projects = PortfolioService;

        var me = this,
            id = $state.params.id;


        this.load = function(id){

            if(id)
            {
                this.projects.find(id, function(project){
                    me.project = project;
                });
            }
            else{
                me.project = new Portfolio();
            }
        };

        this.save = function()
        {
            PortfolioService.save(me.project);
        };

        this.load(id);

    });