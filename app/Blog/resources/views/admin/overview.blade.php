<div class="row wrapper wrapper-content" ng-controller="BlogController as vm" ng-init="vm.options = {{ system_options() }}" ng-cloak>

    <div class="ibox" st-table="vm.posts" st-pipe="vm.list">

        <tabset>

            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" st-click-refresh active="vm.options.locales[locale.locale].active" select="vm.changeTab(locale.locale)">

                <div class="ibox-title">
                    <h5>{{ Lang::get('blog::admin.post.index') }}</h5>
                </div>

            </tab>

        </tabset>

        <div class="ibox-content">

            <table class="table table-hover table-striped table-responsive" ng-show="vm.posts">
                <thead>
                <tr>
                    <th colspan="6">

                        <div class="row">

                            <div class="col-xs-3">
                                <div class="dropdown" data-api="dropdown">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">{{ Lang::get('blog::admin.actions.actions') }}&nbsp;<span class="caret">&nbsp;</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="select-all" data-trigger="select-all" href="">{{ Lang::get('blog::admin.actions.select-all') }}</a>
                                        </li>
                                        <li>
                                            <a class="select-none" data-trigger="select-none" href="">{{ Lang::get('blog::admin.actions.select-none') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a class="remove" data-trigger="remove" href="">{{ Lang::get('blog::admin.actions.remove') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group col-xs-12">
                                    <div class="input-group-addon" style="width:39px;">
                                        <span class="fa fa-search" ng-show="!vm.loading"></span>
                                        <span class="fa fa-refresh" ng-show="vm.loading"></span>
                                    </div>
                                    <input st-search="query" type="search" ng-change="vm.test()" name="search" ng-model="vm.query" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <a class="btn btn-sm btn-primary pull-right" ng-click="vm.newPost()">{{ Lang::get('blog::admin.post.create') }}</a>
                            </div>

                        </div>


                    </th>
                </tr>
                </thead>
                <tbody ng-hide="vm.loading">
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6" st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="post in vm.posts" ui-sref="admin.blog.post({id: post.id})" class="blog-post-overview">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <p>
                            <input type="checkbox" class="filled-in" id="row@{{ $index + 1 }}" checked="checked" />
                            <label for="row@{{ $index + 1 }}">@{{ $index + 1 }}</label>
                        </p>
                    </td>
                    <td width="0%">&nbsp;</td>
                    <td>
                        <div class="">
                            <img class="pull-left img-responsive img-rounded" ng-src="@{{ post.images[0].sizes[0].path }}"/>
                            <h4>@{{ post.translations[vm.options.locale].title }}</h4>
                            @{{ post.translations[vm.options.locale].extract }}
                        </div>
                    </td>
                    <td>@{{ post.tags.length }}</td>
                    <td>@{{ post.translations[vm.options.locale].created_at | fromNow }}</td>
                    <td>@{{ post.translations[vm.options.locale].updated_at | fromNow }}</td>
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
                <a class="btn btn-primary btn-block btn-lg" ng-click="vm.newPost()">{{ Lang::get('blog::admin.post.create') }}</a>
            </div>

        </div>

    </div>

</div>