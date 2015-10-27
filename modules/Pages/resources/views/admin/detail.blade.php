<div class="row wrapper-content" ng-controller="PageDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">

            @include('pages::admin.page-text')

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3" ng-show="vm.page.id">

            @include('pages::admin.page-tags')

            @include('pages::admin.page-images')

        </div>
    </div>

</div>