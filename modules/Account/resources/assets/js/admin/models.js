(function () {
    'use strict';

    angular.module('account')
        .factory('AccountContactInformation', function ($resource) {
            return $resource('api/admin/account/account-contact-information/:id', {
                id: '@id'
            }, {
                load: {
                    method: 'GET',
                },
                update: {
                    method: 'PUT',
                }
            });
        })


        .factory('Membership', function ($resource) {

            return $resource('api/admin/account/members/membership/:id', {
                id: '@id',
            }, {
                list: {
                    isArray: true,
                    method: 'GET',
                }
            });

        })

        .factory('MembershipInvitation', function ($resource) {
            return $resource('api/admin/account/members/invitation/:id', {
                id: '@id'
            }, {
                list: {
                    isArray: true,
                    method: 'GET'
                }
            });
        })

        .factory('Team', function ($resource) {
            return $resource('api/admin/account/team/:id', {
                id: '@id',
            }, {
                list: {
                    isArray: true,
                    method: 'GET'
                },
                update: {
                    method: 'PUT',
                }
            })
        })

        .factory('Client', function ($resource, Image) {

            return $resource('api/admin/account/client/:id', {
                id: '@id',
            }, {
                list: {
                    isArray: true,
                    method: 'GET',
                    transformResponse: function (clients) {
                        clients = angular.fromJson(clients);

                        _.each(clients, function (client) {
                            if (client.images)
                            {
                                client.images = new Image(client.images);
                            }
                        });

                        return clients;
                    },
                },
                update: {
                    method: 'PUT'
                }
            })

        });

})();