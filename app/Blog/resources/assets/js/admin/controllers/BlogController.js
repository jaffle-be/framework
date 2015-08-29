angular.module('blog')
    .controller('BlogController', function ($scope, Blog, BlogService, $sce) {

        $scope.renderHtml = function(html_code)
        {
            return $sce.trustAsHtml(html_code);
        };

        //start with true so we don't see the layout flash
        this.loading = true;
        this.rpp = 15;
        this.total = 0;
        this.posts = [];

        var me = this;

        this.newPost = function()
        {
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
            me.loading = true;
            //cannot use this here
            var pagination = table.pagination;
            var page = Math.ceil(pagination.start / me.rpp) + 1;

            Blog.query({
                page: page,
                query: table.search.predicateObject ? table.search.predicateObject.query : '',
                locale: me.options.locale,
            }, function (response) {
                me.total = response.total;
                me.posts = response.data;
                pagination.numberOfPages = response.last_page;
                me.loading = false;
            });
        };

        this.check = function ($event) {
            $event.stopPropagation();
            return false;
        }
    });