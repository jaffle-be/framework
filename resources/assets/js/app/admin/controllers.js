function MainCtrl() {

    this.addAlert = function() {
        this.alerts.push({msg: 'Another alert!'});
    };

    this.closeAlert = function(index) {
        this.alerts.splice(index, 1);
    };


};

angular
    .module('app')
    .controller('MainCtrl', MainCtrl)
    .controller('ExampleCtrl', Example);