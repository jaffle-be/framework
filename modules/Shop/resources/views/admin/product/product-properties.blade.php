<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('shop::admin.product-properties') }}</h5>
    </div>

    <div class="ibox-content">

        <div as-sortable="groupSortingHandlers" ng-model="vm.product.propertyGroups">

            <div ng-repeat="group in vm.product.propertyGroups" as-sortable-item>

                <h3>@{{ group.translations[vm.options.locale].name }}

                    <i class="fa fa-arrows" as-sortable-item-handle></i>
                </h3>

                <div as-sortable="propertySortingHandlers" ng-model="vm.product.baseProperties[group.id]">

                    <div ng-repeat="property in vm.product.baseProperties[group.id]" class="form-group" as-sortable-item>

                        <i class="fa fa-arrows" as-sortable-item-handle></i>

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

                <div class="clearfix"></div>

            </div>
        </div>
    </div>

</div>