(function () {
    'use strict';

    angular.module('marketing')
        .controller('NewsletterSubscriptionController', function ($scope, NewsletterSubscription) {

            //start with true so we don't see the layout flash
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.subscriptions = [];

            var me = this;

            this.list = function (table) {
                me.table = table;
                me.loadSubscriptions()
            };

            this.getPage = function (start) {
                return Math.ceil(start / me.rpp) + 1;
            };

            this.loadSubscriptions = function () {
                me.loading = true;
                NewsletterSubscription.get({
                    page: me.getPage(me.table.pagination.start),
                }, function (response) {
                    me.total = response.total;
                    me.subscriptions = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.check = function ($event) {
                $event.stopPropagation();
                return false;
            }

            this.batchDelete = function () {
                var subscriptions = this.selectedSubscriptions();

                NewsletterSubscriptionService.batchDelete(subscriptions, function () {
                    me.loadSubscriptions();
                });
            };

            this.selectedSubscriptions = function () {
                var subscriptions = [];

                _.each(this.subscriptions, function (subscription) {
                    if (subscription.isSelected)
                    {
                        subscriptions.push(subscription.id);
                    }
                });

                return subscriptions;
            }
        });

})();