function MainController($scope, toaster, $pusher, PUSHER_API_KEY, $window) {

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

    var channel = pusher.subscribe('private-' + alias);

    channel.bind('system.hard-reload', function () {
        $window.location.reload();
    });

    this.toaster = {
        'time-out': 3000,
        'close-button': true,
        'progress-bar': true
    };
}

angular
    .module('system')
    .controller('MainController', MainController);