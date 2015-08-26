angular.module('blog')
    .factory('Blog', function ($resource) {
        return $resource('api/admin/blog/:id', {id: '@id'}, {
            query: {
                isArray: false
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
                transformRequest: function(data)
                {
                    _.each(data.translations, function(item){
                        if( item.publish_at instanceof Date)
                        {
                            var date = moment(item.publish_at)
                            item.publish_at = date.format('DD/MM/YYYY');
                        }
                    });

                    return angular.toJson(data);
                }
            }
        });
    });