(function () {
    'use strict';

    angular.module('marketing')
        .controller('NewsletterCampaignController', function ($scope, NewsletterCampaign, NewsletterCampaignService, $sce) {

            $scope.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            //start with true so we don't see the layout flash
            this.loading = true;
            this.rpp = 15;
            this.total = 0;
            this.campaigns = [];

            var me = this;

            this.newCampaign = function () {
                var campaign = new NewsletterCampaign();
                NewsletterCampaignService.save(campaign);
            };

            this.changeTab = function (locale) {
                this.query = '';
                this.options.locales[this.options.locale].active = false;
                //set the new one and cache active one
                this.options.locales[locale].active = true;
                this.options.locale = locale;
            };

            this.activeTab = function (locale) {
                return this.locale == locale;
            };

            this.list = function (table) {
                me.table = table;
                me.loadCampaigns()
            };

            this.getPage = function (start) {
                return Math.ceil(start / me.rpp) + 1;
            };

            this.loadCampaigns = function () {
                me.loading = true;
                NewsletterCampaign.query({
                    page: me.getPage(me.table.pagination.start),
                    query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                    locale: me.options.locale,
                }, function (response) {
                    me.total = response.total;
                    me.campaigns = response.data;
                    me.table.pagination.numberOfPages = response.last_page;
                    me.loading = false;
                });
            };

            this.check = function ($event) {
                $event.stopPropagation();
                return false;
            }

            this.batchDelete = function () {
                var campaigns = this.selectedCampaigns();

                NewsletterCampaignService.batchDelete(campaigns, function () {
                    me.loadCampaigns();
                });
            };

            this.selectedCampaigns = function () {
                var campaigns = [];

                _.each(this.campaigns, function (campaign) {
                    if (campaign.isSelected)
                    {
                        campaigns.push(campaign.id);
                    }
                });

                return campaigns;
            }
        });

})();