<div class="ibox" ng-controller="LocaleController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="ibox-title">
        <h5>{{ Lang::get('system::admin.locales') }}</h5>
    </div>

    <div class="ibox-content">

        <div class="form-group col-md-3" ng-repeat="locale in vm.options.systemLocales">
            <input type="checkbox" name="locales" id="@{{ locale.slug }}" class="filled-in" ng-model="locale.activated"
                   ng-change="vm.save(locale)">
            <label for="@{{ locale.slug }}">@{{ locale.translations[vm.options.locale].name }}</label>
        </div>

        <div class="clearfix"></div>

    </div>

</div>
