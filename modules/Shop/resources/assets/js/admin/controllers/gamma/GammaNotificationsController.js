(function () {
    'use strict';

    angular.module('shop')
        .controller('GammaNotificationsController', function ($scope, toaster, GammaNotificationsService) {

            this.page = 1;
            this.totalItems = 0;
            this.notifications = [];

            var me = this;

            var error = function (response) {
                console.log(response);
            };

            this.accept = function (notification) {
                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return item.id == notification.id;
                    });
                };

                GammaNotificationsService.accept([notification.id], success, error);
            };

            this.review = function (notification) {
                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return item.id == notification.id;
                    });
                };

                GammaNotificationsService.review([notification.id], success, error);
            };

            this.deny = function (notification) {
                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return item.id == notification.id;
                    });
                };

                GammaNotificationsService.deny([notification.id], success, error);
            };

            this.batchAccept = function () {
                var ids = this.selectedNotifications();

                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return _.findIndex(ids) !== -1;
                    });
                };

                GammaNotificationsService.accept(ids, success, error);
            };

            this.batchReview = function () {
                var ids = this.selectedNotifications();

                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return _.findIndex(ids) !== -1;
                    });
                };

                GammaNotificationsService.review(ids, success, error);
            };

            this.batchDeny = function () {
                var ids = this.selectedNotifications();

                var success = function () {
                    _.remove(me.notifications, function (item) {
                        return _.findIndex(ids) !== -1;
                    });
                };

                GammaNotificationsService.deny(ids, success, error);
            };

            this.load = function () {
                GammaNotificationsService.load({
                    page: me.page
                }, function (response) {
                    me.notifications = response.data;
                    me.totalItems = response.total;
                });
            };

            this.selectedNotifications = function () {
                var notifications = [],
                    me = this;

                _.each(this.notifications, function (notification) {
                    if (notification.isSelected)
                    {
                        notifications.push(notification.id);
                    }
                });

                return notifications;
            };

            this.load();

        });

})();