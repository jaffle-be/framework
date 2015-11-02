(function () {
    'use strict';

    angular.module('blog')
        .controller('BlogController', function ($scope, Blog, BlogService, $sce) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.posts = [];

            var me = this;

            this.newPost = function () {
                var post = new Blog();
                BlogService.save(post);
            };

            this.changeTab = function (locale) {
                this.query = '';
                this.options.locales[this.options.locale].active = false;
                //set the new one and cache active one
                this.options.locales[locale].active = true;
                this.options.locale = locale;
            };

            this.activeTab = function (locale) {
                return this.locale == locale;
            };

            this.list = function (table) {
                me.table = table;
                me.loadPosts()
            };

            this.getPage = function (start) {
                return Math.ceil(start / me.rpp) + 1;
            };

            this.loadPosts = function () {
                me.loading = true;
                Blog.query({
                    page: me.getPage(me.table.pagination.start),
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {
                    me.total = response.total;
                    me.posts = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.check = function ($event) {
                $event.stopPropagation();
                return false;
            }

            this.batchDelete = function () {
                var posts = this.selectedPosts();

                BlogService.batchDelete(posts, function () {
                    me.loadPosts();
                });
            };

            this.batchPublish = function () {
                var posts = this.selectedPosts();

                BlogService.batchPublish(posts, me.options.locale, function () {

                });
            };

            this.batchUnpublish = function () {
                var posts = this.selectedPosts();

                BlogService.batchUnpublish(posts, me.options.locale, function () {

                });
            };

            this.selectedPosts = function () {
                var posts = [];

                _.each(this.posts, function (post) {
                    if (post.isSelected)
                    {
                        posts.push(post.id);
                    }
                });

                return posts;
            }
        });

})();