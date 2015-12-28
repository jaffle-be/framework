(function () {
    angular.module('system')
        .factory('Pusher', function ($pusher, System, $q, $window) {

            'use strict';


            var deferred = $q.defer();

            var Service = {
                pusher: false,
                channel: false,
                then: function(success, error)
                {
                    deferred.promise.then(success, error);
                }
            }

            Service.promise = deferred.promise;

            System.then(function()
            {
                var client = new Pusher(System.options.pusher.apikey, {
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                });

                //we'd need a channel for each account
                var alias = System.options.pusher.channel;
                var pusher = $pusher(client);
                var channel = pusher.subscribe('private-' + alias);

                Service.channel = channel;
                Service.pusher = pusher;

                //add hard reload event
                channel.bind('system.hard-reload', function () {
                    $window.location.reload();
                });

                deferred.resolve();
            });

            return Service;
        });

})();
