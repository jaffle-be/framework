angular.module('shop')
    .controller('GammaCategoryController', function ($scope, GammaService) {

        this.gamma = GammaService;
        this.page = 1;

        var me = this;

        this.save = function(category)
        {
            GammaService.category(category.id, category.activated)
        };

        this.load = function()
        {
            GammaService.categories({
                page: this.page
            }, function(categories)
            {
                me.categories = categories;
            });
        };

        this.load();

    });