<div class="row wrapper wrapper-content" ng-controller="NewsletterSubscriptionController as vm" ng-init="vm.options = {{ system_options() }}" ng-cloak>

    <div class="ibox" st-table="vm.subscriptions" st-pipe="vm.list">

        <div class="ibox-title">
            <h5>{{ Lang::get('marketing::admin.subscription.index') }}</h5>
        </div>

        <div class="ibox-content">

            <table class="table table-hover table-striped table-responsive vertical" ng-show="vm.subscriptions">
                <tbody ng-hide="vm.loading">
                <tr ng-show="vm.table.pagination.numberOfPages">
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="5" st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="subscription in vm.subscriptions" class="marketing-subscription-overview">
                    <td>
                        @{{ subscription.email }}
                    </td>
                </tr>
                <tr ng-show="vm.table.pagination.numberOfPages">
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="5" st-change="vm.list"></td>
                </tr>
                </tbody>
                <tfoot ng-show="vm.loading">
                <tr>
                    <td class="text-center" style="vertical-align: middle;" height="300" colspan="5">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>

        </div>

    </div>

</div>