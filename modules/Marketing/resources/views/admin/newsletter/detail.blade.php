<div class="row wrapper-content" ng-controller="NewsletterCampaignDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')

    <div class="mypace" ng-hide="vm.campaign">
        <div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ Lang::get('marketing::admin.loading') }}</h5>
                </div>
            </div>

        </div>
    </div>

    <div ng-show="vm.campaign">
        <div ng-show="vm.campaign.translations[vm.options.locale].mailchimp" ng-cloak>

            <div class="row">

                <div class="col-md-6">
                    @include('marketing::admin.newsletter.send-stats')
                </div>

                <div class="col-md-6">
                    @include('marketing::admin.newsletter.sending')
                </div>

            </div>

        </div>

        <div ng-hide="vm.campaign.translations[vm.options.locale].mailchimp" ng-cloak>
            @include('marketing::admin.newsletter.settings')

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    @include('marketing::admin.newsletter.builder')

                </div>

                <div class="col-xs-12 col-md-6">

                    @include('marketing::admin.newsletter.widgets')

                </div>
            </div>
        </div>
    </div>


</div>