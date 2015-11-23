(function () {
    'use strict';

    angular.module('shop')
        .factory('GammaNotificationsService', function ($timeout, $http) {

            return {
                load: function (params, success) {
                    $http.get('/api/admin/shop/gamma/notifications', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                accept: function (notifications, success, error) {
                    $http.post('/api/admin/shop/gamma/notifications/accept', {
                        notifications: notifications,
                    }).then(function (response) {
                        return response.data;
                    }).then(success, error);
                },
                review: function (notifications, success, error) {
                    $http.post('/api/admin/shop/gamma/notifications/review', {
                        notifications: notifications,
                    }).then(function (response) {
                        return response.data;
                    }).then(success, error);
                },
                deny: function (notifications, success, error) {
                    $http.post('/api/admin/shop/gamma/notifications/deny', {
                        notifications: notifications,
                    }).then(function (response) {
                        return response.data;
                    }).then(success, error);
                },
            };

        });

})();