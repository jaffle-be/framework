function MainCtrl() {

    this.addAlert = function() {
        this.alerts.push({msg: 'Another alert!'});
    };

    this.closeAlert = function(index) {
        this.alerts.splice(index, 1);
    };

};


function blogController($http){

    this.currentPage = 1;
    this.totalItems = 0;
    this.posts = [];

    var me = this;

    this.list = function()
    {
        $http.get('admin/blog/page', [

        ]).success(function(posts)
        {
            me.posts = posts;

            console.log(posts);

        });
    };

    this.show = function()
    {

    };


    this.save = function()
    {

    };


    this.list();
}


angular
    .module('app')
    .controller('MainCtrl', MainCtrl)
    .controller('BlogCtrl', blogController);