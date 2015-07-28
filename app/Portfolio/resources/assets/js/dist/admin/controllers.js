angular.module('portfolio')
    .controller('PortfolioController', function (Portfolio, PortfolioService, $state) {

        //start with true so we don't see the layout flash
        this.loading = true;
        this.rpp = 15;
        this.total = 0;
        this.projects = [];

        var me = this;

        this.list = function(table) {

            me.table = table;
            me.loading = true;
            //cannot use this here
            var pagination = table.pagination;
            var page = Math.ceil(pagination.start / me.rpp) + 1;

            Portfolio.query({
                page: page,
                query: table.search.predicateObject ? table.search.predicateObject.query : '',
                locale: me.options.locale,
            }, function (response) {

                me.total = response.total;
                me.projects = response.data;
                pagination.numberOfPages = response.last_page;
                me.loading = false;
            });
        };

        this.newProject = function()
        {
            var project = new Portfolio();
            PortfolioService.save(project, function(newProject)
            {
                $state.go('admin.portfolio.detail', {id: newProject.id});
            });
        };
    });
angular.module('portfolio')
    .controller('PortfolioDetailController', function (Portfolio, PortfolioService, MembershipService, $state) {

        this.projects = PortfolioService;
        this.memberships = [];
        this.collaborators = [];

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