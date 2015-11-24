<div class="row wrapper-content" ng-controller="ProductDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')


    <div class="ibox">
        <div class="ibox-tabs">

            <uib-tabset>

                <uib-tab heading="{{ Lang::get('shop::admin.product.base') }}" active="vm.mainTabs[0]"></uib-tab>
                <uib-tab heading="{{ Lang::get('shop::admin.product.properties') }}" active="vm.mainTabs[1]" ng-show="vm.product.hasMainCategory"></uib-tab>

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

    {{--<div class="col-xs-12">

        <div class="alert alert-danger">
            <div class="title">Drafting</div>
            <p>
                drafting should be enabled by pressing a user button.
                the server should then create a new draft document.
                this should clone all tags etc to the draft document.
                the draft itself should be tied to the original document.

                upon publishing the draft will overwrite the original one completely
                (except for maybe some original fields like the created timestamp)
            </p>
        </div>

    </div>--}}

</div>