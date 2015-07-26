angular.module('blog')
    .controller('BlogController', function ($scope, Blog, BlogService) {

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
angular.module('blog')
    .controller('BlogDetailController', function ($state, Blog, BlogService) {

        this.posts = BlogService;

        var me = this,
            id = $state.params.id;

        this.load = function (id) {
            if (id) {
                this.post = this.posts.find(id, function (post) {
                    me.post = post;
                });
            }
            else {
                this.post = new Blog();
            }
        };

        /**
         * trigger a save for a document that exists but hold the autosave when it's a
         * document we're creating.
         *
         * @param manual
         */
        this.save = function () {
            var me = this;
            me.drafting = true;

            if(me.post.id)
            {
                this.posts.save(me.post);
            }
        };

        this.publish = function () {
            var me = this;
            this.posts.publish(this.post, function () {
                me.drafting = false;
            });
        };

        this.load(id);
    });