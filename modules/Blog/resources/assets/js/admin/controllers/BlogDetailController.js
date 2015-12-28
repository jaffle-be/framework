(function () {
    'use strict';

    angular.module('blog')
        .controller('BlogDetailController', function ($scope, $state, System, Blog, BlogService) {

            this.options = {};
            this.posts = BlogService;
            $scope.status = {
                datepickerStatus: false
            };

            var me = this,
                id = $state.params.id;

            this.load = function (id) {

                System.then(function(){
                    me.options = System.options;
                });

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
             *
             */
            this.save = function () {
                var me = this;
                me.drafting = true;

                if (me.post.id) {
                    this.posts.save(me.post);
                }
            };

            this.publish = function () {
                var me = this;
                this.posts.publish(this.post, function () {
                    me.drafting = false;
                });
            };

            this.openDatepicker = function ($event) {
                $scope.status.datepickerStatus = !$scope.status.datepickerStatus;
                $event.preventDefault();
                $event.stopPropagation();
            };

            this.delete = function () {
                this.posts.delete(me.post, function () {
                    $state.go('admin.blog.posts');
                });
            };

            this.load(id);
        });

})();
