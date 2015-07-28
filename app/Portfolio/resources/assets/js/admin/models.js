angular.module('portfolio')
    .factory('Portfolio', function ($resource) {

        return $resource('api/admin/portfolio/:id', {id: '@id'}, {

            query: {
                isArray: false,
            },
            get: {
                method: 'GET',
                transformResponse: function(response)
                {
                    response = angular.fromJson(response);

                    if(response.translations.length == 0)
                    {
                        response.translations = {};
                    }

                    return response;
                }
            },
            update: {
                method: 'PUT',
            },
            collaborators: {
                isArray:true,
                method: 'GET',
                url: 'api/admin/portfolio/:id/collaboration'
            },
            toggleCollaboration:{
                method: 'POST',
                url :'api/admin/portfolio/:id/collaboration'
            }
        });

    });