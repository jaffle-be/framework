angular.module('shop')
    .controller('GammaBrandController', function ($scope, GammaService) {

        this.gamma = GammaService;
        this.page = 1;

        var me = this;

        this.save = function(brand)
        {
            GammaService.brand(brand.id, brand.activated)
        };

        this.load = function()
        {
            GammaService.brands({
                page: this.page
            }, function(brands)
            {
                me.brands = brands;
            });
        };

        this.load();

    });