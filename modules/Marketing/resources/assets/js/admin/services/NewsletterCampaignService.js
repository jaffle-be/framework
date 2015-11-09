(function () {
    'use strict';

    angular.module('marketing')

        .factory('NewsletterCampaignService', function (NewsletterCampaign, NewsletterCampaignWidget, $state, $timeout, $http) {

            function Service() {
                //when creating, it should get locked so it won't trigger another save, till we have the id back from the server.
                this.locked = false;
                this.timeout = false;
                this.timeoutWidgets = {};
                this.storeNewWidget = storeNewWidget;
                this.searchResource = searchResource;
                this.linkResourceToWidget = linkResourceToWidget;

                var me = this;


                this.find = function (id, success) {
                    //also pass through the locale parameter (not the UI locale, but the input locale for the campaign itself
                    NewsletterCampaign.get({id: id}, function(response){

                        response.widgets = _.map(response.widgets, function(item){
                            var data = _.assign({
                                campaign_id: id
                            }, item);

                            return new NewsletterCampaignWidget(data);
                        });

                        success(response);
                    });
                };

                this.save = function (campaign) {

                    //use a copy, so the response will not reset the form to the last saved instance while typing.
                    var destination = angular.copy(campaign);

                    if (this.locked)
                        return;

                    if (!destination.id)
                    {
                        this.locked = true;

                        return destination.$save(function () {
                            me.locked = false;
                            $state.go('admin.marketing.campaign', {id: destination.id});
                        });
                    }
                    else
                    {
                        if (this.timeout)
                        {
                            $timeout.cancel(this.timeout);
                        }

                        this.timeout = $timeout(function () {
                            return destination.$update(function () {
                                //do something on success
                            });
                        }, 400);
                    }
                };

                this.saveWidget = function(widget)
                {
                    var destination = angular.copy(widget);

                    if (this.timeoutWidgets[destination.id])
                    {
                        $timeout.cancel(this.timeoutWidgets[destination.id]);
                    }

                    this.timeoutWidgets[destination.id] = $timeout(function () {
                        return destination.$update(function () {
                            //do something on success
                        });
                    }, 400);
                };

                this.delete = function (campaign, success) {
                    campaign.$delete().then(success);
                };

                this.batchDelete = function (campaigns, success) {
                    $http.campaign('/api/admin/marketing/newsletter/batch-delete', {
                        campaigns: campaigns
                    }).then(success);
                };
            }

            function storeNewWidget(campaign, widget)
            {
                var entity = _.assign(widget, {campaign_id: campaign.id});
                entity = new NewsletterCampaignWidget(widget);

                return entity.$save().then(function(response){
                    campaign.widgets.push(new NewsletterCampaignWidget(response));
                });
            }

            function searchResource(value, locale)
            {
                return $http.get('/api/admin/marketing/newsletter/search', {
                    params: {
                        query: value,
                        locale: locale
                    }
                }).then(function(response){
                    return response.data;
                });
            }

            function linkResourceToWidget(type, widget, resource)
            {
                if(!(type == 'one' || type == 'two'))
                {
                    throw new Error('invalid argument, only support for 2 elements');
                }

                if(type == 'one')
                {
                    widget.resource_type = resource.type;
                    widget.resource_id = resource.value;
                }
                else{
                    widget.other_resource_type = resource.type;
                    widget.other_resource_id = resource.value;
                }

                return widget.$update();
            }

            return new Service();
        });

})();