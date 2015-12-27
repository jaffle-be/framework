<div class="row wrapper wrapper-content" ng-controller="ProductOverviewController as vm" ng-cloak>

    <div class="ibox" st-table="vm.products" st-pipe="vm.list">

        @include('system::admin.locale-tabs', ['clickRefresh' => true])

        <div class="ibox-title">
            <h5>{{ Lang::get('shop::admin.product.index') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="alert alert-info">
                //this needs to become a typehead so that we can suggest products,
                //the template returned should (to be perfect) show the product,
                //the image, the brand and the categories (and maybe also the tags?)
                //when something is in the searchbox, we should show a button
                //to allow us to do a full search
                //when we do get a result, we can use it by selecting it
                //it should then take us to that specific page instead of doing a search
                //you can use the payload to determine which state to go to
            </div>

            <table class="table table-hover table-striped table-responsive vertical" ng-show="vm.products">
                <thead>
                <tr>
                    <th colspan="6">

                        <div class="row" ng-if="!vm.creating">

                            <div class="col-xs-3">
                                <div class="dropdown" data-api="dropdown">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                       href="#">{{ Lang::get('shop::admin.actions.actions') }}&nbsp;<span class="caret">&nbsp;</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a select-all="vm.products"
                                               href="">{{ Lang::get('shop::admin.actions.select-all') }}</a>
                                        </li>
                                        <li>
                                            <a select-none="vm.products"
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
                                        <li class="divider"></li>
                                        <li>
                                            <a ng-really="vm.batchDelete()"
                                               href="">{{ Lang::get('shop::admin.actions.remove') }}</a>
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
                                           uib-typeahead="item.label for item in vm.searchProduct($viewValue)"
                                           typeahead-loading="searching"
                                           typeahead-on-select="vm.goTo($item)"
                                           typeahead-wait-ms="400"
                                           typeahead-highlight="true"
                                           ng-model="vm.searchInput">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <a class="btn btn-sm btn-primary pull-right"
                                   ng-click="vm.startCreating()">{{ Lang::get('shop::admin.product.create') }}</a>
                            </div>

                        </div>

                        <div ng-if="vm.creating">
                            @include('shop::admin.product.creator')
                        </div>

                    </th>
                </tr>
                </thead>
                <tbody ng-hide="vm.loading">
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6"
                        st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="product in vm.products" ui-sref="admin.shop.product({id: product.id})"
                    class="shop-product-overview">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <input type="checkbox" class="filled-in" id="row@{{ $index + 1 }}"
                               ng-model="product.isSelected"/>
                        <label for="row@{{ $index + 1 }}">@{{ $index + 1 }}</label>
                    </td>
                    <td width="150">
                        <img class="img-responsive img-rounded" ng-src="@{{ product.images[0].sizes[0].path }}"/></td>
                    <td>
                        <div>
                            <h4 ng-bind-html="renderHtml(vm.getTitle(product))"></h4>
                            <h6 ng-bind-html="renderHtml(product.translations[vm.options.locale].title)"></h6>

                            <p ng-bind-html="renderHtml(product.translations[vm.options.locale].cached_extract)"></p>
                        </div>
                    </td>
                    <td>@{{ product.tags.length }}</td>
                    <td>@{{ product.translations[vm.options.locale] ? product.translations[vm.options.locale].created_at : product.created_at | fromNow }}</td>
                    <td>@{{ product.translations[vm.options.locale] ? product.translations[vm.options.locale].updated_at : product.updated_at | fromNow }}</td>
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
