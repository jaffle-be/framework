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