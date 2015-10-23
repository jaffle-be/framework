angular.module('blog')

    .factory('BlogService', function (Blog, $state, $timeout, $http) {

        function Service() {
            //when creating, it should get locked so it won't trigger another save, till we have the id back from the server.
            this.locked = false;
            this.timeout = false;

            var me = this;

            this.find = function (id, success) {
                //also pass through the locale parameter (not the UI locale, but the input locale for the post itself
                Blog.get({id: id}, success);
            };

            this.save = function (post) {

                //use a copy, so the response will not reset the form to the last saved instance while typing.
                var destination = angular.copy(post);

                if (this.locked)
                    return;

                if (!destination.id)
                {
                    this.locked = true;

                    return destination.$save(function () {
                        me.locked = false;
                        $state.go('admin.blog.post', {id: destination.id});
                    });
                }
                else
                {
                    if (this.timeout)
                    {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function () {
                        return destination.$update(function(){
                            _.each(post.translations, function(item, locale){
                                item.slug = destination.translations[locale].slug
                            });
                        });
                    }, 400);
                }
            };

            this.delete = function(post, success)
            {
                post.$delete().then(success);
            };

            this.batchDelete = function(posts, success)
            {
                $http.post('/api/admin/blog/batch-delete', {
                    posts: posts
                }).then(success);
            };

            this.batchPublish = function(posts, locale, success)
            {
                $http.post('/api/admin/blog/batch-publish', {
                    posts: posts,
                    locale: locale
                }).then(success);
            };

            this.batchUnpublish = function(posts, locale, success)
            {
                $http.post('/api/admin/blog/batch-unpublish', {
                    posts: posts,
                    locale: locale
                }).then(success);
            };
        }

        return new Service();
    });