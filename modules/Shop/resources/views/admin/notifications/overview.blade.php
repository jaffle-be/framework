<div class="wrapper wrapper-content gamma-notifications" ng-controller="GammaNotificationsController as vm" ng-init="vm.options = {{ system_options() }}">

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ Lang::get('shop::admin.notifications') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="alert alert-info">
                {{ Lang::get('shop::admin.notifications-what-to-do') }}
            </div>

            <div class="text-center">
                <uib-pagination total-items="vm.totalItems" items-per-page="15" ng-model="vm.page" ng-change="vm.load()" max-size="10" class="pagination-sm" boundary-links="true"></uib-pagination>
            </div>

            <table class="table table-hover table-striped table-responsive vertical">
                <thead>
                <tr>
                    <th colspan="6">

                        <div class="dropdown" data-api="dropdown">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">{{ Lang::get('blog::admin.actions.actions') }}&nbsp;<span class="caret">&nbsp;</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a select-all="vm.notifications" href="">{{ Lang::get('blog::admin.actions.select-all') }}</a>
                                </li>
                                <li>
                                    <a select-none="vm.notifications" href="">{{ Lang::get('blog::admin.actions.select-none') }}</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a ng-confirm="vm.batchAccept()" href="">{{ Lang::get('blog::admin.actions.accept') }}</a>
                                </li>
                                <li>
                                    <a ng-confirm="vm.batchReview()" href="">{{ Lang::get('blog::admin.actions.review') }}</a>
                                </li>
                                <li>
                                    <a ng-really="vm.batchDeny()" href="">{{ Lang::get('blog::admin.actions.deny') }}</a>
                                </li>
                            </ul>
                        </div>

                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="notification in vm.notifications">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <input type="checkbox" class="filled-in" id="row@{{ $index + 1 }}" ng-model="notification.isSelected"/>
                        <label for="row@{{ $index + 1 }}">@{{ $index + 1 }}</label>
                    </td>
                    <td width="0%">&nbsp;</td>

                    <td>
                        <div ng-switch="" on="notification.type">

                            <div ng-switch-when="activate">
                                products from @{{ notification.brand.translations[vm.options.locale].name }} in @{{ notification.category.translations[vm.options.locale].name }}
                            </div>

                            <div ng-switch-when="deactivate">
                                <strong>removing</strong> products from @{{ notification.brand.translations[vm.options.locale].name }} in @{{ notification.category.translations[vm.options.locale].name }}
                            </div>

                        </div>

                    </td>

                    <td>
                        <button class="btn btn-primary" ng-click="vm.accept(notification)"><i class="fa fa-check"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-success" ng-click="vm.review(notification)">
                            <i class="fa fa-search-plus"></i></button>
                    </td>
                    <td>
                        <button class="btn btn-danger" ng-click="vm.deny(notification)"><i class="fa fa-trash"></i>
                        </button>
                    </td>

                </tr>
                </tbody>
            </table>

            <div class="text-center">
                <uib-pagination total-items="vm.totalItems" items-per-page="15" ng-model="vm.page" ng-change="vm.load()" max-size="10" class="pagination-sm" boundary-links="true"></uib-pagination>
            </div>
        </div>

    </div>

</div>
