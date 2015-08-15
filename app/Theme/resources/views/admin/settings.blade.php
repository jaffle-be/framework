<div class="wrapper-content" ng-controller="ThemeController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ Lang::get('theme::settings.theme-selection') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="alert alert-danger" ng-show="vm.failed">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{ Lang::get('theme::settings.error') }}</strong> {{ Lang::get('theme::settings.something-bad-happened') }}
            </div>

            <div class="col-lg-offset-1 col-lg-4 text-center" style="padding-top: 40px">
                <div class="form-group">

                    <label class="control-label" for="theme">{{ Lang::get('theme::settings.active-theme') }}</label>
                    <select class="form-control" ng-model="vm.theme" ng-options="theme.name for theme in vm.themes"></select>
                </div>

                <div class="form-group">
                    <button class="btn btn-warning" ng-click="vm.activate()">{{ Lang::get('theme::settings.change-theme') }}</button>
                </div>
            </div>

            <div class="col-lg-6 col-lg-offset-1">
                <image-input owner-type="'account-logo'" owner-id="{{ $account->id }}" locale="vm.options.locale" limit="1"></image-input>
            </div>

            <div class="clearfix"></div>

        </div>

    </div>


    <div class="row" ng-show="vm.theme">

        @include('menu::admin.settings')

    </div>

</div>

