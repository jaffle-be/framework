<div ng-controller="MenuController as vm" ng-init="vm.options = {{ system_options() }}">
    <div class="row">

        <div class="col-md-6">

            <div class="ibox">

                <div class="ibox-tabs">

                    <tabset>

                        <tab ng-repeat="menu in vm.menus" heading="@{{ menu.name }}" select="vm.menu = menu"></tab>

                    </tabset>

                    <div class="ibox-content ibox-with-footer">

                        <ul class="menu-items" data-as-sortable="vm.sortables" data-ng-model="vm.menu.items">

                            <li ng-repeat="item in vm.menu.items" as-sortable-item>

                                <a ng-click="vm.item = item">@{{ item.translations[vm.options.locale].name }}</a>
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

        <div class="col-md-6" ng-show="vm.item">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('menu::admin.menu-item') }}</h5>
                </div>

                <div class="ibox-content ibox-with-footer">

                    <div class="form-group">

                        <div class="well well-sm">{{ Lang::get('menu::admin.url-explanation') }}</div>

                        <label for="url">
                            {{ Lang::get('menu::admin.url') }}
                        </label>

                        <input class="form-control" type="text" name="url" id="url" ng-model="vm.item.url" ng-change="vm.saveItem()"/>

                        <div class="checkbox">
                            <input type="checkbox" id="target_blank" class="filled-in" ng-model="vm.item.target_blank" ng-change="vm.saveItem(false)">

                            <label for="target_blank">{{ Lang::get('menu::admin.target_blank') }}</label>
                        </div>

                    </div>

                    <div ng-repeat="locale in vm.options.locales">

                        <div class="form-group">

                            <label for="locale">
                                @{{ locale.slug }}
                            </label>

                            <input class="form-control" type="text" name="locale" id="locale" ng-model="vm.item.translations[locale.slug].name" ng-change="vm.saveItem()"/>

                        </div>

                    </div>

                    <div ng-hide="vm.item.id" class="text-center">

                        <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

                    </div>


                    <div class="footer" ng-show="vm.item.id">
                        {{ Lang::get('menu::admin.delete-menu-item') }}
                        <button class="pull-right btn btn-danger" ng-really="vm.deleteItem()"><i class="fa fa-trash"></i>
                        </button>
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