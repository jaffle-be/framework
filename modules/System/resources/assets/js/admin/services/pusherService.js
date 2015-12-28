(function () {
    angular.module('system')
        .factory('Pusher', function ($pusher, System, $q) {

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
                //for now channels are 'mocked' to be separate.
                //if in the future this would change, simply search replace
                //Pusher.channel Pusher.channels.system or Pusher.channels.account etc
                Service.channel = pusher.subscribe('private-' + alias);
                Service.pusher = pusher;

                deferred.resolve();
            });

            return Service;
        });

})();
