(function () {
    'use strict';

    angular.module('blog', [])
        .config(function ($stateProvider) {

            $stateProvider
                .state('admin.blog', {
                    abstract: true,
                    url: "/blog",
                    template: '<ui-view/>'
                })
                .state('admin.blog.posts', {
                    url: "/posts",
                    templateUrl: "templates/admin/blog/overview",
                })
                .state('admin.blog.post', {
                    url: '/post/:id',
                    templateUrl: "templates/admin/blog/detail",
                });
        });

})();