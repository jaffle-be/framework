(function () {
    'use strict';

    angular.module('marketing')
        .factory('NewsletterCampaign', function ($resource, Image) {
            return $resource('api/admin/marketing/newsletter/campaign/:id', {id: '@id'}, {
                query: {
                    isArray: false
                },
                get: {
                    method: 'GET',
                    transformResponse: function (response) {
                        response = angular.fromJson(response);

                        if (response.translations.length == 0)
                        {
                            response.translations = {};
                        }

                        response.images = _.map(response.images, function (image) {
                            return new Image(image);
                        });

                        response.widgets = _.map(response.widgets, function (widget) {
                            if (widget.translations.length == 0)
                            {
                                widget.translations = {};
                            }
                            return widget;
                        });

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                }
            });
        })


        .factory('NewsletterSubscription', function ($http) {
            return {
                get: function (data, success) {
                    return $http.get('api/admin/marketing/newsletter/subscriptions', {
                        params: data
                    }).then(function (response) {
                        success(response.data)
                    });
                }
            };
        })

        .factory('NewsletterCampaignWidget', function ($resource) {

            return $resource('api/admin/marketing/newsletter/campaign/:campaign_id/campaign-widget/:id', {
                id: '@id',
                campaign_id: '@campaign_id',
            }, {
                get: {
                    method: 'GET',
                    transformResponse: function (response) {
                        response = angular.fromJson(response);

                        if (response.translations.length == 0)
                        {
                            response.translations = {};
                        }

                        return response;
                    }
                },
                update: {
                    method: 'PUT',
                }
            });

        });


})();