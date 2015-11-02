(function () {
    angular.module('system')
        .factory('Pusher', function ($pusher, PUSHER_API_KEY) {

            'use strict';

            var client = new Pusher(PUSHER_API_KEY, {
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            });

            //we'd need a channel for each account
            var alias = $('meta[name="account-alias"]').attr('content');
            var pusher = $pusher(client);
            //for now channels are 'mocked' to be separate.
            //if in the future this would change, simply search replace
            //Pusher.channel Pusher.channels.system or Pusher.channels.account etc
            var channel = pusher.subscribe('private-' + alias);

            return {
                pusher: pusher,
                channel: channel
            }
        });

})();