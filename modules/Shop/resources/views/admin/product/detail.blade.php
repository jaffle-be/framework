<div class="row wrapper-content" ng-controller="ProductDetailController as vm">

    @include('system::admin.locale-tabs')


    <div class="ibox">
        <div class="ibox-tabs">

            <uib-tabset>

                <uib-tab heading="{{ Lang::get('shop::admin.product.base') }}" active="vm.mainTabs[0]"></uib-tab>
                <uib-tab heading="{{ Lang::get('shop::admin.product.properties') }}" active="vm.mainTabs[1]"
                         ng-show="vm.product.hasMainCategory"></uib-tab>

            </uib-tabset>

        </div>
    </div>


    <div class="row" ng-show="vm.mainTabs[0]">
        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">

            @include('shop::admin.product.product-text')

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3" ng-show="vm.product.id">

            @include('shop::admin.product.product-tags')

            @include('shop::admin.product.product-images')

        </div>
    </div>

    <div ng-show="vm.mainTabs[1]">

        @include('shop::admin.product.product-properties')

    </div>

</div>
