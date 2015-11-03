<div class="row wrapper wrapper-content portfolio-overview" ng-controller="PortfolioController as vm" ng-init="vm.options = {{ system_options() }}" ng-cloak>

    <div class="ibox" st-table="vm.projects" st-pipe="vm.list">

        @include('system::admin.locale-tabs', ['clickRefresh' => true])

        <div class="ibox-title">
            <h5>{{ Lang::get('portfolio::admin.project.index') }}</h5>
        </div>


        <div class="ibox-content">

            <table class="table table-hover table-striped table-responsive vertical" ng-show="vm.projects">
                <thead>
                <tr>
                    <th colspan="7">

                        <div class="row">

                            <div class="col-xs-3">
                                <div class="dropdown" data-api="dropdown">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">{{ Lang::get('portfolio::admin.actions.actions') }}&nbsp;<span class="caret">&nbsp;</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a select-all="vm.projects" href="">{{ Lang::get('portfolio::admin.actions.select_all') }}</a>
                                        </li>
                                        <li>
                                            <a select-none="vm.projects" data-trigger="select-none" href="">{{ Lang::get('portfolio::admin.actions.select_none') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a ng-confirm="vm.batchPublish()" href="">{{ Lang::get('portfolio::admin.actions.publish') }}</a>
                                        </li>
                                        <li>
                                            <a ng-confirm="vm.batchUnpublish()" href="">{{ Lang::get('portfolio::admin.actions.unpublish') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a ng-really="vm.delete()" href="">{{ Lang::get('portfolio::admin.actions.remove') }}</a>
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
                                    <input st-search="query" type="search" ng-change="vm.test()" name="search" ng-model="vm.query" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <a class="btn btn-sm btn-primary pull-right" ng-click="vm.newProject()">{{ Lang::get('portfolio::admin.project.new-project') }}</a>
                            </div>

                        </div>


                    </th>
                </tr>
                </thead>
                <tbody ng-hide="vm.loading">
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="7" st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="project in vm.projects" ui-sref="admin.portfolio.detail({id: project.id})" class="portfolio-overview">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <input type="checkbox" class="filled-in" id="row@{{ $index + 1 }}" ng-checked="project.isSelected"/>
                        <label for="row@{{ $index + 1 }}">@{{ $index + 1 }}</label>
                    </td>
                    <td width="0%">&nbsp;</td>
                    <td width="60%">
                        <div class="">
                            <img class="pull-left img-responsive img-rounded" ng-src="@{{ project.images[0].sizes[0].path }}"/>
                            <h4 ng-bind-html="renderHtml(project.translations[vm.options.locale].title)"></h4>
                            <span ng-bind-html="renderHtml(project.translations[vm.options.locale].extract)"></span>
                        </div>

                    </td>
                    <td><i class="fa fa-check" ng-show="project.translations[vm.options.locale].published"></i></td>
                    <td>@{{ project.tags.length }}</td>
                    <td>@{{ project.translations[vm.options.locale] ? project.translations[vm.options.locale].created_at : project.created_at | fromNow }}</td>
                    <td>@{{ project.translations[vm.options.locale] ? project.translations[vm.options.locale].updated_at : project.updated_at | fromNow }}</td>
                </tr>
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6" st-change="vm.list"></td>
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

            <div>
                <a class="btn btn-block btn-primary btn-lg" ng-click="vm.newProject()">{{ Lang::get('portfolio::admin.project.new-project') }}</a>
            </div>

        </div>

    </div>

</div>