<div class="row text-center">

    <div class="col-md-4">

        <div class="form-group">
            <input type="text" class="form-control"
                   uib-typeahead="item.label for item in vm.searchBrand($viewValue)"
                   typeahead-loading="searching"
                   typeahead-on-select="vm.selectBrandForCreation($item)"
                   typeahead-wait-ms="400"
                   typeahead-highlight="true"
                   ng-model="vm.typeheadBrand" placeholder="{{ Lang::get('shop::admin.product.brand') }}">
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">
            <input type="text" class="form-control" ng-model="vm.creatingProduct.name" placeholder="{{ Lang::get('shop::admin.product.name') }}">
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">
            <input type="text" class="form-control" ng-model="vm.creatingProduct.ean" placeholder="{{ Lang::get('shop::admin.product.ean') }}">
        </div>

    </div>

</div>

<div class="text-center">

    <button class="btn btn-primary" ng-click="vm.createProduct()">{{ Lang::get('shop::admin.actions.create') }}</button>
    <button class="btn btn-info" ng-click="vm.cancelCreating()">{{ Lang::get('shop::admin.actions.cancel') }}</button>

</div>