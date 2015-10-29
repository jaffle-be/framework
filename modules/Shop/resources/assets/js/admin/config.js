angular.module('shop', [])
    .config(function ($stateProvider) {
        $stateProvider
            .state('admin.shop', {
                abstract: true,
                url: "/shop",
                template: '<ui-view/>'
            })
            .state('admin.shop.categories', {
                url: "/categories",
                templateUrl: "templates/admin/categories/overview"
            })
            .state('admin.shop.brands', {
                url: '/brands',
                templateUrl: "templates/admin/brands/overview"
            })
            .state('admin.shop.products', {
                url: "/products",
                templateUrl: "templates/admin/products/overview"
            })
            .state('admin.shop.product', {
                url: '/product/:id',
                templateUrl: "templates/admin/products/detail"
            });

    });