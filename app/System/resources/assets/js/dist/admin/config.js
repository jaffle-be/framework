angular.module('system', [])

    .filter('myDate', function() {
        return function(dateString) {
            return moment(new Date(dateString)).format('DD/MM/YYYY')
        };
    })

    .filter('fromNow', function()
    {
        return function(dateString) {
            return moment(new Date(dateString)).fromNow()
        };
    });