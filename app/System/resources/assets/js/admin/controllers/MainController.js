function MainController($scope, toaster) {

    this.toaster = {
        'time-out': 3000,
        'close-button':true,
        'progress-bar': true
    };
}

angular
    .module('system')
    .controller('MainController', MainController);