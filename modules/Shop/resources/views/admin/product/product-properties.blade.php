<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('shop::admin.product-properties') }}</h5>
    </div>

    <div class="ibox-content">

        <div ng-repeat="property in vm.product.properties">

            <div class="form-group col-md-6 col-lg-4">

                <div ng-switch="" on="property.property.type">

                    <div ng-switch-when="boolean">

                        <input type="checkbox" class="filled-in" ng-model="property.boolean"/>
                        <label for="published">@{{ property.property.translations[vm.options.locale].name }}</label>

                    </div>

                    <div ng-switch-when="string">

                        <label class="control-label">@{{ property.property.translations[vm.options.locale].name }}</label>
                        <input class="form-control" type="text" ng-model="property.translations[vm.options.locale].string">

                    </div>

                    <div ng-switch-when="numeric">

                        <label class="control-label">@{{ property.property.translations[vm.options.locale].name }}</label>
                        <input class="form-control" type="text" ng-model="property.numeric">

                    </div>

                    <div ng-switch-when="float">

                        <label class="control-label">@{{ property.property.translations[vm.options.locale].name }}</label>
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