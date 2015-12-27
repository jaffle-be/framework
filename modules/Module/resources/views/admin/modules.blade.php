<div class="ibox" ng-controller="ModuleController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="ibox-title">
        <h5>{{ Lang::get('module::admin.modules') }}</h5>
    </div>

    <div class="ibox-content">

        <div class="form-group col-md-3" ng-repeat="module in vm.options.systemModules">
            <input type="checkbox" name="modules" id="module@{{ module.id }}" class="filled-in"
                   ng-model="module.activated" ng-change="vm.save(module)">
            <label for="module@{{ module.id }}">@{{ module.translations[vm.options.locale].name }}</label>
        </div>

        <div class="clearfix"></div>

    </div>

</div>
