angular.module('blog')

    .factory('BlogService', function (Blog, $state, $timeout) {

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

                post = angular.copy(post);

                if (this.locked)
                    return;

                if (!post.id) {
                    this.locked = true;

                    return post.$save(function () {
                        me.locked = false;
                        $state.go('admin.blog.post', {id: post.id});
                    });
                }
                else {
                    if (this.timeout) {
                        $timeout.cancel(this.timeout);
                    }

                    this.timeout = $timeout(function () {
                        return post.$update();
                    }, 400);
                }
            };
        }

        return new Service();
    });