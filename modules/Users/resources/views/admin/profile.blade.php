<div class="row wrapper-content" ng-controller="ProfileController as vm">

    @include('system::admin.locale-tabs')


    <div class="ibox">
        <div class="ibox-tabs">
            <uib-tabset>
                <uib-tab heading="{{ Lang::get('users::admin.tabs.profile') }}" active="vm.mainTabs[0]"></uib-tab>
                <uib-tab heading="{{ Lang::get('users::admin.tabs.bio') }}" active="vm.mainTabs[1]"></uib-tab>
            </uib-tabset>
        </div>
    </div>

    <div ng-show="vm.mainTabs[0]">

        @include('users::admin.tabs.profile')

    </div>

    <div class="row" ng-show="vm.mainTabs[1]">

        @include('users::admin.tabs.skills')

    </div>

    <div class="clearfix"></div>
</div>
