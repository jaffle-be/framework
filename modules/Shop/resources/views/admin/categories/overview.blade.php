<div class="wrapper wrapper-content" ng-controller="GammaCategoryController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="row search-navigation">

        <div class="col-md-6 col-lg-4">

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                </div>
                <input type="text" class="form-control"
                       uib-typeahead="item.label for item in vm.searchCategory($viewValue)"
                       typeahead-loading="searching"
                       typeahead-on-select="vm.load($item)"
                       typeahead-wait-ms="400"
                       typeahead-highlight="true"
                       ng-model="vm.searchInput">
                <div class="input-group-addon">
                    <i ng-show="vm.selectedCategory" ng-click="vm.clearSelection()" class="fa fa-times"></i>
                    <span ng-hide="vm.selectedCategory">&nbsp;&nbsp;</span>
                </div>
            </div>

        </div>


        <div class="col-md-6 col-lg-8">
            <div class="text-center">
                <uib-pagination total-items="vm.totalItems" ng-model="vm.page" ng-change="vm.load()" max-size="10" class="pagination-sm" boundary-links="true" items-per-page="5"></uib-pagination>
            </div>
        </div>


    </div>

    <div class="ibox" ng-repeat="category in vm.categories">


        <div class="ibox-title">
            <h5 ng-hide="vm.hasAnythingSelected(category)">
                <div class="switch">
                    <label>
                        <input id="brand@{{ category.id }}" type="checkbox" ng-model="category.activated" ng-change="vm.save(category)" ng-disabled="category.activeBrands > 0">
                        <span class="lever"></span>
                        <span class="name">@{{ category.translations[vm.options.locale].name }}</span>
                    </label>
                </div>
            </h5>

            <h5 ng-show="vm.hasAnythingSelected(category)">
                <span class="name">@{{ category.translations[vm.options.locale].name }}</span>
            </h5>

        </div>


        <div class="ibox-content">
            <ul class="row nav">
                <li class="col-md-4" ng-repeat="brand in category.brands">
                    <input type="checkbox" id="brand@{{ brand.id }}category@{{ category.id }}" class="filled-in" ng-model="brand.selected" ng-change="vm.saveDetail(category, brand)" ng-disabled="!category.activated || !brand.activated">
                    <label for="brand@{{ brand.id }}category@{{ category.id }}">@{{ brand.translations[vm.options.locale].name }}</label>
                    &nbsp;<i ng-show="brand.inReview" class="fa fa-shield"></i>

                    <div class="switch pull-right" ng-show="!brand.activated">
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


    <div class="text-center">
        <uib-pagination total-items="vm.totalItems" ng-model="vm.page" ng-change="vm.load()" max-size="10" class="pagination-sm" boundary-links="true" items-per-page="5"></uib-pagination>
    </div>

</div>