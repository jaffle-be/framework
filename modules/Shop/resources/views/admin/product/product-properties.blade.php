<div class="ibox">

    <div class="ibox-content">
        <form class="form-horizontal" ng-submit="vm.createGroup()">

            <label class="control-label col-xs-4">{{ Lang::get('shop::admin.properties.group') }}</label>

            <div class="input-group col-xs-8 col-md-6 col-lg-4">
                <input type="text" class="form-control" ng-model="vm.newGroup">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i><span class="hidden-sm">{{ Lang::get('shop::admin.actions.new') }}</span></button>
                </div>
            </div>

        </form>
    </div>

</div>

<div as-sortable="sorting.groupSortingHandlers" ng-model="vm.product.propertyGroups" class="product-property-groups">

    <div ng-repeat="group in vm.product.propertyGroups" as-sortable-item is-disabled="sorting.changingProperty" class="ibox product-property-group">

        <div class="ibox-title form-inline">
            <i class="pull-left fa fa-arrows" as-sortable-item-handle>&nbsp;</i>
            <h5>
                <input type="text" class="form-control" ng-model="group.translations[vm.options.locale].name" ng-change="vm.updateGroup(group)" placeholder="{{ Lang::get('shop::admin.properties.group') }}">
            </h5>
            <button ng-show="vm.canDeleteGroup(group)" class="btn btn-danger btn-sm pull-right" ng-really="vm.deleteGroup(group)"><i class="fa fa-trash"></i></button>
        </div>

        <div class="ibox-content">

            <div as-sortable="sorting.propertySortingHandlers" is-disabled="sorting.changingGroup" ng-model="vm.product.baseProperties[group.id]" class="property-wrapper">

                <div ng-repeat="property in vm.product.baseProperties[group.id]" as-sortable-item>

                    <div class="product-property">

                        <div ng-switch="" on="property.type">

                            <div ng-switch-when="boolean">


                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon" as-sortable-item-handle>
                                            <i class="fa fa-arrows">&nbsp;</i>{{ Lang::get('shop::admin.properties.name') }}
                                        </div>
                                        <input type="text" class="form-control" ng-model="property.translations[vm.options.locale].name" ng-change="vm.updateProperty(property)">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" ng-really="vm.deleteProperty(property)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group col-md-6 col-md-offset-1">
                                    <input type="checkbox" class="filled-in" ng-checked="vm.product.properties[property.id].boolean"/>
                                    <label for="published">@{{ property.translations[vm.options.locale].name }}</label>
                                </div>

                            </div>

                            <div ng-switch-when="string">

                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon" as-sortable-item-handle>
                                            <i class="fa fa-arrows">&nbsp;</i>{{ Lang::get('shop::admin.properties.name') }}
                                        </div>
                                        <input type="text" class="form-control" ng-model="property.translations[vm.options.locale].name" ng-change="vm.updateProperty(property)">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" ng-really="vm.deleteProperty(property)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-6 col-md-offset-1">
                                    <div class="input-group">
                                        <div class="input-group-addon">{{ Lang::get('shop::admin.properties.value') }}</div>
                                        <input class="form-control" type="text" ng-model="vm.product.properties[property.id].translations[vm.options.locale].string" ng-change="vm.updateValue(property)">
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                            </div>

                            <div ng-switch-when="numeric">

                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon" as-sortable-item-handle>
                                            <i class="fa fa-arrows">&nbsp;</i>{{ Lang::get('shop::admin.properties.name') }}
                                        </div>
                                        <input type="text" class="form-control" ng-model="property.translations[vm.options.locale].name" ng-change="vm.updateProperty(property)">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" ng-really="vm.deleteProperty(property)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-6 col-md-offset-1">
                                    <div class="input-group">
                                        <div class="input-group-addon">{{ Lang::get('shop::admin.properties.value') }}</div>
                                        <input class="form-control" type="text" ng-model="vm.product.properties[property.id].numeric" ng-change="vm.updateValue(property)">
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                            </div>

                            <div ng-switch-when="float">

                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon" as-sortable-item-handle>
                                            <i class="fa fa-arrows">&nbsp;</i>{{ Lang::get('shop::admin.properties.name') }}
                                        </div>
                                        <input type="text" class="form-control" ng-model="property.translations[vm.options.locale].name" ng-change="vm.updateProperty(property)">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" ng-really="vm.deleteProperty(property)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-6 col-md-offset-1">
                                    <div class="input-group">
                                        <div class="input-group-addon">{{ Lang::get('shop::admin.properties.value') }}</div>
                                        <input class="form-control" type="text" ng-model="vm.product.properties[property.id].float" ng-change="vm.updateValue(property)">
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                            </div>

                            <div ng-switch-when="options">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon" as-sortable-item-handle>
                                            <i class="fa fa-arrows">&nbsp;</i>{{ Lang::get('shop::admin.properties.name') }}
                                        </div>
                                        <input type="text" class="form-control" ng-model="property.translations[vm.options.locale].name" ng-change="vm.updateProperty(property)">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" ng-really="vm.deleteProperty(property)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-6 col-md-offset-1">

                                    <select ng-model="vm.product.properties[property.id].option_id" ng-options="option.id as option.translations[vm.options.locale].name for option in property.options" class="form-control"></select>

                                    <div class="input-group">
                                        <div class="input-group-addon">{{ Lang::get('shop::admin.properties.value') }}</div>
                                        <input class="form-control" type="text" ng-model="vm.newOption">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                    </div>

                </div>

                <div class="clearfix"></div>
            </div>

        </div>

    </div>
</div>
