function MainController() {

    this.alerts = [];

    this.addAlert = function() {
        this.alerts.push({msg: 'Another alert!'});
    };

    this.closeAlert = function(index) {
        this.alerts.splice(index, 1);
    };

}

angular
    .module('system')
    .controller('MainController', MainController);