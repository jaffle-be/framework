angular.module('system')
    .directive('selectAll', function(){

        return {
            restrict: 'A',
            scope:{
                items: '=selectAll',
            },
            link: function(scope, element, attr, ctrl)
            {
                element.bind('click', function()
                {
                    _.each(scope.items, function(item){
                        item.isSelected = true;
                    });

                    scope.$apply();
                });
            }
        }
    })
    .directive('selectNone', function()
    {
        return {
            restrict: 'A',
            scope:{
                items: '=selectNone',
            },
            link: function(scope, element, attr, ctrl)
            {
                element.bind('click', function()
                {
                    _.each(scope.items, function(item){
                        item.isSelected = false;
                    });

                    scope.$apply();
                });
            }
        }
    });
