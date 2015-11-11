(function()
{
    'use strict';

    angular.module('shop')
        .factory('GammaNotificationsService', function ($timeout, $http) {

            return {
                load: function (params, success) {
                    $http.get('/api/admin/notifications', {
                        params: params
                    }).then(function (response) {
                        success(response.data);
                    });
                },
                accept: function (notifications, success, error) {
                    $http.post('/api/admin/notifications/accept', {
                        notifications: notifications,
                    }).then(success, error);
                },
                review: function (notifications, success, error) {
                    $http.post('/api/admin/notifications/review', {
                        notifications: notifications,
                    }).then(success, error);
                },
                deny: function (notifications, success, error) {
                    $http.post('/api/admin/notifications/deny', {
                        notifications: notifications,
                    }).then(success, error);
                },
            };

        });

})();