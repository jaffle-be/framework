<div class="row wrapper-content" ng-controller="NewsletterCampaignDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')


    @include('marketing::admin.newsletter.settings')

    @include('marketing::admin.newsletter.mailchimp-coupler')


    <div class="row">
        <div class="col-xs-12 col-md-6">

            @include('marketing::admin.newsletter.builder')

        </div>

        <div class="col-xs-12 col-md-6">

            @include('marketing::admin.newsletter.widgets')

        </div>
    </div>

</div>