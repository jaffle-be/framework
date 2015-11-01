<div class="wrapper wrapper-content" ng-controller="GammaBrandController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="ibox" ng-repeat="brand in vm.brands">

        <div class="ibox-title">
            <h5>
                <div class="switch">
                    <label>
                        <input id="brand@{{ brand.id }}" type="checkbox" ng-model="brand.activated" ng-change="vm.save(brand)">
                        <span class="lever"></span>
                        <span class="name">@{{ brand.translations[vm.options.locale].name }}</span>
                    </label>
                </div>
            </h5>
        </div>

        <div class="ibox-content">
            <ul class="row nav">
                <li class="col-md-4" ng-repeat="category in brand.categories">
                    <input type="checkbox" id="category@{{ category.id }}brand@{{ brand.id }}" class="filled-in" ng-model="category.selected" ng-change="vm.saveDetail(brand, category)" ng-disabled="!brand.activated || !category.activated">
                    <label for="category@{{ category.id }}brand@{{ brand.id }}">@{{ category.translations[vm.options.locale].name }}</label>
                    &nbsp;<i class="fa fa-shield" ng-show="category.inReview"></i>
                </li>
            </ul>
        </div>

    </div>

</div>