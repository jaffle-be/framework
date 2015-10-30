<div class="row wrapper wrapper-content" ng-controller="GammaCategoryController as vm" ng-init="vm.options = {{ system_options() }}">
    <ul class="nav">
        <li ng-repeat="category in vm.categories" class="col-md-4">
            <input type="checkbox" id="category@{{ category.id }}" class="filled-in" ng-model="category.activated" ng-change="vm.save(category)">
            <label for="category@{{ category.id }}">@{{ category.translations[vm.options.locale].name }}</label>
        </li>
    </ul>
</div>