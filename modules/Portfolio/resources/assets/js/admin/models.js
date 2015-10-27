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

                    if(response.date)
                    {
                        response.date = moment(response.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }

                    return response;
                }
            },
            update: {
                method: 'PUT',
                transformRequest: function(request)
                {
                    if(typeof request.date == 'string')
                    {
                        request.date = moment(request.date, 'DD/MM/YYYY').format('YYYY-MM-DD');
                    }

                    if(request.date instanceof Date)
                    {
                        var date = moment(request.date);
                        request.date = date.format('YYYY-MM-DD')
                    }

                    return angular.toJson(request)
                }
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