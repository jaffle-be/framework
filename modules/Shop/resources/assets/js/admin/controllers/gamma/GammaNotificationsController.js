(function () {
    'use strict';

    angular.module('shop')
        .controller('GammaNotificationsController', function (toaster, GammaNotificationsService, System) {

            this.options = System.options;
            this.page = 1;
            this.totalItems = 0;
            this.notifications = [];
            this.loaded = false;

            var me = this;

            var error = function (response) {
                console.log(response);
            };

            this.updateTable = function (response) {
                me.page = response.page;
                me.notifications = response.data;
                me.totalItems = response.total;
            };

            this.accept = function (notification) {
                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.accept([notification.id], success, error);
            };

            this.review = function (notification) {
                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.review([notification.id], success, error);
            };

            this.deny = function (notification) {
                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.deny([notification.id], success, error);
            };

            this.batchAccept = function () {
                var ids = this.selectedNotifications();

                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.accept(ids, success, error);
            };

            this.batchReview = function () {
                var ids = this.selectedNotifications();

                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.review(ids, success, error);
            };

            this.batchDeny = function () {
                var ids = this.selectedNotifications();

                var success = function (response) {
                    me.updateTable(response);
                };

                GammaNotificationsService.deny(ids, success, error);
            };

            this.load = function () {
                GammaNotificationsService.load({
                    page: me.page
                }, function (response) {
                    me.loaded = true;
                    me.notifications = response.data;
                    me.totalItems = response.total;
                });
            };

            this.selectedNotifications = function () {
                var notifications = [],
                    me = this;

                _.each(this.notifications, function (notification) {
                    if (notification.isSelected) {
                        notifications.push(notification.id);
                    }
                });

                return notifications;
            };

            this.load();

        });

})();
