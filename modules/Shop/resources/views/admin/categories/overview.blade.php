<div class="wrapper wrapper-content" ng-controller="GammaCategoryController as vm" ng-init="vm.options = {{ system_options() }}">


    <div class="ibox" ng-repeat="category in vm.categories">

        <div class="ibox-title">
            <h5>
                <div class="switch">
                    <label>
                        <input id="brand@{{ category.id }}" type="checkbox" ng-model="category.activated" ng-change="vm.save(category)" ng-disabled="category.activeBrands > 0">
                        <span class="lever"></span>
                        <span class="name">@{{ category.translations[vm.options.locale].name }}</span>
                    </label>
                </div>
            </h5>

        </div>

        <div class="ibox-content">
            <ul class="row nav">
                <li class="col-md-4" ng-repeat="brand in category.brands">
                    <input type="checkbox" id="brand@{{ brand.id }}category@{{ category.id }}" class="filled-in" ng-model="brand.selected" ng-change="vm.saveDetail(category, brand)" ng-disabled="!category.activated || !brand.activated">
                    <label for="brand@{{ brand.id }}category@{{ category.id }}">@{{ brand.translations[vm.options.locale].name }}</label>
                    &nbsp;<i ng-show="brand.inReview" class="fa fa-shield"></i>

                    <div class="switch pull-right">
                        <label>
                            <input id="brand@{{ brand.id }}category@{{ category.id }}activated" type="checkbox" ng-model="brand.activated" ng-change="vm.subSave(brand)">
                            <span class="lever"></span>
                            &nbsp;
                        </label>
                    </div>
                </li>
            </ul>
        </div>

    </div>

</div>