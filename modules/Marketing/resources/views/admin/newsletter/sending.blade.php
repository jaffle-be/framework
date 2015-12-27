<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('marketing::admin.newsletter.sending') }}</h5>
        <button ng-show="vm.campaign.translations[vm.options.locale].mailchimp.is_ready" ng-confirm="vm.sendCampaign()"
                class="pull-right btn btn-primary">
            <i class="fa fa-send"></i></button>
    </div>

    <div class="ibox-content">

        <div ng-bind-html="vm.renderHtml(vm.campaign.translations[vm.options.locale].preview.html)"></div>

    </div>

</div>
