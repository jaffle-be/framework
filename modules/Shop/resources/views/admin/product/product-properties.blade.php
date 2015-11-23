<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('shop::admin.product-properties') }}</h5>
    </div>

    <div class="ibox-content">


        <div ng-repeat="(group_id, group) in vm.product.baseProperties">

            <h3>@{{ vm.product.propertyGroups[group_id].translations[vm.options.locale].name }}</h3>

            <div class="row">

                <div ng-repeat="property in group" class="form-group col-md-6">

                    <div ng-switch="" on="property.type">

                        <div ng-switch-when="boolean">

                            <input type="checkbox" class="filled-in" ng-model="vm.product.properties[property.id].boolean"/>
                            <label for="published">@{{ property.translations[vm.options.locale].name }}</label>

                        </div>

                        <div ng-switch-when="string">

                            <label class="control-label">@{{ property.translations[vm.options.locale].name }}</label>
                            <input class="form-control" type="text" ng-model="vm.product.properties[property.id].translations[vm.options.locale].string">

                        </div>

                        <div ng-switch-when="numeric">

                            <label class="control-label">@{{ property.translations[vm.options.locale].name }}</label>
                            <input class="form-control" type="text" ng-model="vm.product.properties[property.id].numeric">

                        </div>

                        <div ng-switch-when="float">

                            <label class="control-label">@{{ property.translations[vm.options.locale].name }}</label>
                            <input class="form-control" type="text" ng-model="property.float">

                        </div>

                        <div ng-switch-when="options">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="clearfix"></div>
    </div>

</div>