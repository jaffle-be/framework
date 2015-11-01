angular.module('shop')
    .controller('GammaCategoryController', function ($scope, GammaService) {

        this.gamma = GammaService;
        this.page = 1;

        var me = this;

        this.save = function(category)
        {
            GammaService.category(category.id, category.activated)
        };

        this.saveDetail = function(category, brand){
            GammaService.detail({
                category: category.id,
                brand: brand.id,
                status: brand.selected
            }, function()
            {
                brand.inReview = !brand.inReview;
            }, function()
            {
                brand.selected = !brand.selected;
            });
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