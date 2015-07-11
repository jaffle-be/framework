<div class="row wrapper wrapper-content" ng-controller="BlogController as vm" ng-init="vm.options = {{ blog_options() }}" ng-cloak>

    <div class="ibox" st-table="vm.posts" st-pipe="vm.list">

        <tabset justified="true">

            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" st-click-refresh active="vm.options.locales[locale.locale].active" select="vm.changeTab(locale.locale)">

                <div class="ibox-title">
                    <h5>{{ Lang::get('blog::admin.post-index') }}</h5>
                </div>

            </tab>

        </tabset>

        <div class="ibox-content">

            <table  class="table table-hover table-striped table-responsive" ng-show="vm.posts">
                <thead>
                <tr>
                    <th colspan="6">

                        <div class="row">

                            <div class="col-xs-3">
                                <div class="dropdown" data-api="dropdown">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">{{ Lang::get('dash/general.acties') }}&nbsp;<span class="caret">&nbsp;</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="select-all" data-trigger="select-all" href="">{{ Lang::get('dash/general.select_all') }}</a>
                                        </li>
                                        <li>
                                            <a class="select-none" data-trigger="select-none" href="">{{ Lang::get('dash/general.select_none') }}</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a class="remove" data-trigger="remove" href="">{{ Lang::get('dash/general.remove') }}</a>
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
                                <a class="btn btn-sm btn-primary pull-right" ui-sref="admin.blog.post">{{ Lang::get('blog::new_post') }}</a>
                            </div>

                        </div>


                    </th>
                </tr>
                </thead>
                <tbody ng-hide="vm.loading">
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6" st-change="vm.list"></td>
                </tr>
                <tr ng-repeat="post in vm.posts" ui-sref="admin.blog.post({postId: post.id})" class="blog-post-overview">
                    <td width="10%" ng-click="$event.stopPropagation()">
                        <label>@{{ $index + 1 }}&nbsp;<input type="checkbox" /></label>
                    </td>
                    <td width="0%">&nbsp;</td>
                    <td>
                        <div class="">
                            <h4>@{{ post.translations[vm.options.locale].title }}</h4>
                            <img class="pull-left img-responsive img-rounded" ng-src="@{{ post.images[0].sizes[0].path }}"/>
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

            <div class="no-posts-box">
                <a ui-sref="admin.blog.post">{{ Lang::get('blog::new_post') }}</a>
            </div>

        </div>

    </div>

</div>