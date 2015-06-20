<div class="row wrapper wrapper-content" ng-controller="BlogCtrl as vm" ng-init="vm.options = {{ blog_options() }}">

    <div class="ibox">

        <tabset justified="true">

            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active" ng-click="vm.setLocale(locale.locale)">

                <div class="ibox-title">
                    <h5>{{ Lang::get('blog::admin.post-index') }}</h5>
                </div>

            </tab>

        </tabset>

        <div class="ibox-content">

            <table st-table="vm.posts" st-pipe="vm.list" class="table table-hover table-striped table-responsive" ng-show="vm.posts">
                <thead>
                <tr>
                    <th>
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
                    </th>
                    <th colspan="2" class="text-center">
                        <input type="search" name="search" class="form-control"/>
                    </th>
                    <th colspan="2">
                        <a class="btn btn-sm btn-primary pull-right" ui-sref="admin.blog.post">{{ Lang::get('blog::new_post') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="post in vm.posts" ui-sref="admin.blog.post({postId: post.id})">
                    <td>
                        @{{ $index + 1 }}&nbsp;<input type="checkbox"/>
                    </td>
                    <td></td>
                    <td>
                        <div class="">
                            <h4>@{{ post.translations[vm.options.locale].title }}</h4>
                            <img class="pull-left" ng-src="@{{ post.images[0].sizes[0].path }}"/>
                            @{{ post.translations[vm.options.locale].extract }}
                        </div>


                    </td>
                    <td>@{{ post.tags.length }}</td>
                    <td>@{{ post.translations[vm.options.locale].created_at | fromNow }}</td>
                    <td>@{{ post.translations[vm.options.locale].updated_at | fromNow }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td class="text-center" st-pagination st-items-by-page="vm.rpp" colspan="6" st-change="vm.list"></td>
                </tr>
                </tfoot>
            </table>

            <div class="no-posts-box">
                <a ui-sref="admin.blog.post">{{ Lang::get('blog::new_post') }}</a>
            </div>

        </div>

    </div>

</div>