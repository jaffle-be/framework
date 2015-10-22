angular.module('system')
    .factory('Locale', function ($http) {
        return {
            toggle: function (locale) {
                $http.post('api/admin/system/locale', locale);
            }
        }
    })
    .factory('Seo', function ($http) {

        return {
            list: function(ownerType, ownerId, locale, success)
            {
                $http({
                    url : 'api/admin/seo',
                    params: {
                        ownerType: ownerType,
                        ownerId: ownerId,
                        locale: locale,
                    }
                }).then(success);
            },
            update: function(ownerType, ownerId, locale, seo)
            {
                //i guess we do not really need a callback.
                //unless maybe for error handling :/
                //if we have no decent global error handling
                $http({
                    url : 'api/admin/seo',
                    method: 'post',
                    data: {
                        ownerType: ownerType,
                        ownerId: ownerId,
                        locale: locale,
                        title: seo.title,
                        description: seo.description,
                        keywords: seo.keywords,
                    }
                });
            }
        }

    });