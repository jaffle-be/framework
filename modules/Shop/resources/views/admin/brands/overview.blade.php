<div class="row wrapper wrapper-content" ng-controller="GammaBrandController as vm" ng-init="vm.options = {{ system_options() }}">
    <ul class="nav">
        <li ng-repeat="brand in vm.brands" class="col-md-4">
            <input type="checkbox" id="brand@{{ brand.id }}" class="filled-in" ng-model="brand.activated" ng-change="vm.save(brand)">
            <label for="brand@{{ brand.id }}">@{{ brand.translations[vm.options.locale].name }}</label>
        </li>
    </ul>
</div>