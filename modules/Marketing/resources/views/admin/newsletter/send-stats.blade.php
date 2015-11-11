<div class="ibox newsletter-widget-stats">

    <div class="ibox-title">
        <h5>{{ Lang::get('marketing::admin.newsletter.send-stats') }}</h5>
    </div>

    <div class="ibox-content">

        <div ng-show="vm.campaign.translations[vm.options.locale].mailchimp.is_ready">

            <div class="alert alert-info">{{ Lang::get('marketing::admin.newsletter.still-need-to-send') }}</div>

        </div>



        <div class="row" ng-show="!vm.campaign.translations[vm.options.locale].mailchimp.is_ready">


            <div class="col-xs-6" ng-repeat="stat in vm.campaign.translations[vm.options.locale].summary">

                <div ng-switch on="stat.meaning">

                    <div ng-switch-when="regular">

                        <div class="form-group regular">
                            <label>@{{ stat.name }}</label>
                            <span>@{{ stat.value }}</span>
                        </div>

                    </div>
                    <div ng-switch-when="bad">

                        <div class="form-group bad">
                            <label>@{{ stat.name }}</label>
                            <span>@{{ stat.value }}</span>
                        </div>

                    </div>

                    <div ng-switch-when="good">

                        <div class="form-group good">
                            <label>@{{ stat.name }}</label>
                            <span>@{{ stat.value }}</span>
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>