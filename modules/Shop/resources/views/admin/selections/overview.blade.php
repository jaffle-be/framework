<div class="row wrapper wrapper-content" ng-controller="SelectionOverviewController as vm"
     ng-init="vm.options = {{ system_options() }}" ng-cloak>

    <div class="ibox" st-table="vm.selections" st-pipe="vm.list">

        @include('system::admin.locale-tabs', ['clickRefresh' => true])

        <div class="ibox-title">
            <h5>{{ Lang::get('shop::admin.product.selections') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="alert alert-info">
                we should put info about how the product is displayed on the site here.
                but only info related to actual shopping or main stuff like the categories (just as a helper)
                so basically all prices, categories, promotions, in-/active
            </div>

            <table class="table table-hover table-striped table-responsive vertical" ng-show="vm.selections">
                <thead>
                <tr>
                    <th colspan="6">

                        <div class="row">

                            <div class="col-xs-3">
                                <div class="dropdown" data-api="dropdown">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                       href="#">{{ Lang::get('shop::admin.actions.actions') }}&nbsp;<span class="caret">&nbsp;</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a select-all="vm.selections"
                                               href="">{{ Lang::get('shop::admin.actions.select-all') }}</a>
                                        </li>
                                        <li>
                                            <a select-none="vm.selections"
                                               href="">{{ Lang::get('shop::admin.actions.select-none') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a ng-confirm="vm.batchPublish()"
                                               href="">{{ Lang::get('shop::admin.actions.publish') }}</a>
                                        </li>
                                        <li>
                                            <a ng-confirm="vm.batchUnpublish()"
                                               href="">{{ Lang::get('shop::admin.actions.unpublish') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group col-xs-12">
                                    <div class="input-group-addon" style="width:39px;">
                                        <span class="fa fa-search" ng-show="!vm.loading"></span>

                                        <div class="sk-spinner sk-spinner-cube-grid" ng-show="vm.loading">
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                            <div class="sk-cube"></div>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control"
                                           uib-typeahead="item.label for item in vm.searchSelection($viewValue)"
                                           typeahead-loading="searching"
                                           typeahead-on-select="vm.goTo($item)"
                                           typeahead-wait-ms="400"
                                           typeahead-highlight="true"
                                           ng-model="vm.searchInput"></div>

                            </div>
                            <div class="col-xs-3">
                            </div>

                        </div>

                    </th>
                </tr>
                </thead>
                <tbody ng-hide="vm.loading">
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6"
                        st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="selection in vm.selections" ui-sref="admin.shop.selection({id: selection.id})"
                    class="shop-selection.product-overview">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <input type="checkbox" class="filled-in" id="row@{{ $index + 1 }}"
                               ng-model="selection.product.isSelected"/>
                        <label for="row@{{ $index + 1 }}">@{{ $index + 1 }}</label>
                    </td>
                    <td width="150"><img class="img-responsive img-rounded"
                                         ng-src="@{{ selection.product.images[0].sizes[0].path }}"/></td>
                    <td>
                        <div>
                            <h4 ng-bind-html="renderHtml(vm.getTitle(selection.product))"></h4>
                            <h6 ng-bind-html="renderHtml(selection.product.translations[vm.options.locale].title)"></h6>
                        </div>
                    </td>
                    <td>@{{ selection.product.tags.length }}</td>
                    <td>@{{ selection.product.translations[vm.options.locale] ? selection.product.translations[vm.options.locale].created_at : selection.product.created_at | fromNow }}</td>
                    <td>@{{ selection.product.translations[vm.options.locale] ? selection.product.translations[vm.options.locale].updated_at : selection.product.updated_at | fromNow }}</td>
                </tr>
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6"
                        st-change="vm.list"></td>
                </tr>
                </tbody>
                <tfoot ng-show="vm.loading">
                <tr>
                    <td class="text-center" style="vertical-align: middle;" height="300" colspan="6">
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
