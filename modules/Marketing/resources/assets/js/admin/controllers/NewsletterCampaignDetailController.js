(function () {
    'use strict';

    angular.module('marketing')
        .controller('NewsletterCampaignDetailController', function ($scope, $state, NewsletterCampaign, NewsletterCampaignService, $sce, toaster) {

            this.campaigns = NewsletterCampaignService;
            this.itemsPerRow = 1;
            //active state for tabs
            this.widgetTabs = [true, false];
            this.pageTabs = [true, false];

            var me = this,
                id = $state.params.id;

            this.load = load;
            this.save = save;
            this.delete = deleteCampaign;
            this.addWidget = addWidget;
            this.removeWidget = removeWidget;
            this.saveWidget = saveWidget;
            this.configItemCount = configItemCount;
            this.editing = false;
            this.startEditing = startEditing;
            this.stopEditing = stopEditing;
            this.selectWidgetImage = selectWidgetImage;
            this.showImage = showImage;
            this.showTitle = showTitle;
            this.showText = showText;
            this.showResourceImage = showResourceImage;
            this.showResourceTitle = showResourceTitle;
            this.showResourceText = showResourceText;
            this.widgetImage = widgetImage;
            this.searchElement = searchElement;
            this.linkElement = linkElement;
            this.renderHtml = renderHtml;
            this.prepareToSend = prepareToSend;
            this.sendCampaign = sendCampaign;
            this.isLinked = isLinked;

            this.load(id);

            function load(id) {
                if (id) {
                    me.campaign = me.campaigns.find(id, function (campaign) {
                        me.campaign = campaign;
                        console.log(campaign);
                    });
                }
                else {
                    me.campaign = new NewsletterCampaign();
                }
            };

            /**
             * trigger a save for a document that exists but hold the autosave when it's a
             * document we're creating.
             *
             *
             */
            function save() {
                me.drafting = true;

                if (me.campaign.id) {
                    me.campaigns.save(me.campaign);
                }
            }

            function saveWidget(widget) {
                NewsletterCampaignService.saveWidget(widget);
            }

            function deleteCampaign() {
                me.campaigns.delete(me.campaign, function () {
                    $state.go('admin.marketing.campaigns');
                });
            };

            function addWidget(name) {
                //find the actual widget in our available widgets.
                var widget = _.first(_.where(me.campaign.availableWidgets, {name: name}));

                NewsletterCampaignService.storeNewWidget(me.campaign, widget);
            }

            function removeWidget(widget) {
                widget.$delete().then(function () {
                    _.remove(me.campaign.widgets, function (item) {
                        return item.id == widget.id
                    });
                });
            }

            function configItemCount(widget) {
                if (!widget) {
                    return false;
                }

                var config = _.first(_.where(me.campaign.availableWidgets, {
                    name: widget.path
                }));

                return config.items;
            }

            function startEditing(widget) {
                me.editing = widget;
            }

            function stopEditing() {
                me.editing = false;
            }

            function widgetImage(field) {
                if (me.editing) {
                    return me.editing[field] ? me.editing[field].path : null;
                }
            }

            function selectWidgetImage(field) {
                var id = me.editing[field];
                var image_field = field.substr(0, field.length - 3);

                var image = _.first(_.where(me.campaign.images, {id: id}));

                if (image) {
                    me.editing[image_field] = image;
                    me.saveWidget(me.editing);
                }
            }

            function showImage(image) {
                if (image) {
                    return image.path;
                }

                return 'http://placekitten.com/g/1120/800';
            }

            function showTitle(title) {
                return title ? title : 'Placeholder title';
            }

            function showText(text) {
                return text ? text : 'Some reasonably long placeholder text, so you have an idea how it all looks before you actually write anything.';
            }

            function resourceToUse(type, widget) {
                if (type == 'one') {
                    return widget.resource;
                }
                else if (type == 'two') {
                    return widget.otherResource;
                }
            }

            function showResourceImage(type, widget) {
                var resource = resourceToUse(type, widget);

                if (resource && resource.images) {
                    return resource.images[0].path;
                }

                return 'http://placekitten.com/g/1120/800';
            }

            function showResourceTitle(type, widget) {
                var resource = resourceToUse(type, widget);

                if (resource && resource.translations) {
                    return resource.translations[me.options.locale].title;
                }

                return 'Placeholder title';
            }

            function showResourceText(type, widget) {
                var resource = resourceToUse(type, widget);

                if (resource && resource.translations) {
                    return resource.translations[me.options.locale].cached_extract;
                }

                return 'Some reasonably long placeholder text, so you have an idea how it all looks before you actually write anything.';
            }

            function searchElement(value, locale) {
                return NewsletterCampaignService.searchResource(value, locale);
            }

            function linkElement($item, type) {
                NewsletterCampaignService.linkResourceToWidget(type, me.editing, $item, function () {
                });
            }

            function renderHtml(html_code) {
                return $sce.trustAsHtml(html_code);
            }

            function prepareToSend() {
                var using = me.campaign;
                me.campaign = false;

                function success(campaign) {
                    me.campaign = campaign;
                }

                function error(response) {
                    me.campaign = using;
                    me.campaign.translations[me.options.locale].mail_chimp_campaign_id = false;
                    toaster.error(response.headers().reason);
                }

                NewsletterCampaignService.prepareToSend(using, me.options.locale).then(success, error);
            }

            function sendCampaign() {
                me.campaign.translations[me.options.locale].mailchimp.is_ready = false;
                NewsletterCampaignService.send(me.campaign, me.options.locale).then(function (response) {
                    me.campaign.translations[me.options.locale].summary = response.data
                });
            }

            function isLinked() {
                return me.campaign && me.campaign.translations[me.options.locale].mailchimp;
            }
        });

})();