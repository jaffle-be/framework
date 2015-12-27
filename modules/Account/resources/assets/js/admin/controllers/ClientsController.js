(function () {
    'use strict';

    angular.module('account')
        .controller('ClientsController', function ($scope, Client, $timeout) {
            var me = this;
            this.timeouts = [];
            this.clients = [];
            this.client = false;
            this.saving = false;

            function load() {
                Client.list({}).$promise.then(function (clients) {
                    me.clients = clients;
                });
            }

            this.startEditing = function (client) {
                this.client = client;
            };

            this.freshClient = function () {
                this.client = new Client();
            };

            this.deleteClient = function () {
                if (this.client.id) {
                    this.client.$delete({}, function () {
                        _.remove(me.clients, function (client) {
                            return client.id == me.client.id;
                        });
                        me.stopEditing();
                    });
                }
            };

            this.createClient = function () {
                me.saving = true;

                me.client.$save({}, function (client) {
                    me.client = client;
                    me.clients.push(client);
                    me.saving = false;
                }, function () {
                    me.saving = false;
                });

            };

            this.stopEditing = function () {
                this.client = false;
            };

            this.save = function () {
                if (!this.client.id) {
                    return;
                }

                //don't update UI with returned object
                var client = angular.copy(me.client);

                if (this.timeouts[this.client.id]) {
                    $timeout.cancel(this.timeouts[this.client.id]);
                }

                this.timeouts[this.client.id] = $timeout(function () {
                    client.$update();
                }, 400);
            };

            load();

        });

})();