<div ng-controller="MenuController as vm" ng-init="vm.options = {{ system_options() }}">
    <div class="row">

        <div class="col-md-6">

            <div class="ibox">

                <div class="ibox-tabs">

                    <uib-tabset>

                        <uib-tab ng-repeat="menu in vm.menus" heading="@{{ menu.name }}" select="vm.selectMenu(menu)"></uib-tab>

                    </uib-tabset>

                    <div class="ibox-content ibox-with-footer">

                        <ul class="menu-items" data-as-sortable="vm.sortables" data-ng-model="vm.menu.items">

                            <li ng-repeat="item in vm.menu.items" as-sortable-item ng-class="{active: vm.item.id == item.id}">

                                <a ng-click="vm.startEditing(item)">@{{ item.translations[vm.options.locale].name }}</a>
                                <span>@{{ item.children.length }}</span>
                                <span class="sorter" as-sortable-item-handle><i class="fa fa-arrows"></i></span>

                            </li>

                        </ul>

                        <div class="footer">

                            <div class="row">

                                <div class="col-xs-6">
                                    <button class="btn btn-primary" ng-click="vm.newItem()">{{ Lang::get('menu::admin.new-item') }}</button>
                                </div>
                                <div class="col-xs-6">
                                    <button class="pull-right btn btn-danger" ng-really="vm.deleteMenu()" title="{{ Lang::get('menu::admin.delete-menu') }}">
                                        <i class="fa fa-trash"></i></button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6" ng-show="vm.initialised">

            <div class="ibox">

                <div class="ibox-tabs">

                    <uib-tabset>

                        <uib-tab heading="{{ Lang::get('menu::admin.manual-item') }}" active="vm.tabs['manual']" select="vm.selectTab('manual')">
                            @include('menu::admin.manual-item')
                        </uib-tab>

                        <uib-tab heading="{{ Lang::get('menu::admin.page-item') }}" active="vm.tabs['page']" select="vm.selectTab('page')">
                            @include('menu::admin.page-item')
                        </uib-tab>

                        <uib-tab heading="{{ Lang::get('menu::admin.linkable-route') }}" active="vm.tabs['route']" select="vm.selectTab('route')">
                            @include('menu::admin.route-item')
                        </uib-tab>

                    </uib-tabset>


                    </div>
                </div>



            </div>

        </div>

    </div>

    {{--<div class="row" ng-show="vm.item.children.length">--}}

    {{--<div class="col-md-6">--}}
    {{--<div class="ibox">--}}

    {{--<div class="ibox-title">--}}
    {{--<h5>children</h5>--}}
    {{--</div>--}}

    {{--<div class="ibox-content">--}}

    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}
    {{--<div class="ibox">--}}

    {{--<div class="ibox-title">--}}
    {{--<h5>child details</h5>--}}
    {{--</div>--}}

    {{--<div class="ibox-content">--}}

    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}

</div>