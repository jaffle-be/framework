<script type="text/ng-template" id="templates/admin/layout/navigation">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul side-navigation class="nav" id="side-menu">
                <li class="nav-header">

                    <div class="profile-element">

                        <a ui-sref="admin.profile">

                            @if($user->images->count() == 0)
                                <img alt="image" class="img-circle img-responsive"
                                     src="{{ Gravatar::src($user->email, 200) }}"/>
                            @else
                                <img alt="image" class="img-circle img-responsive"
                                     src="{{ asset($user->images->first()->path) }}"/>
                            @endif
                        </a>

                        <br>

                        <span class="clear">
                                <span class="block m-t-xs fullname">
                                    <a ui-sref="admin.profile"><strong class="font-bold">{{ $user->name }}</strong></a>
                             </span>
                        </span>

                        <a target="_blank" href="{{ store_route('store.home') }}"
                           class="text-muted text-xs block">{{ $account->alias }}</a>

                    </div>
                    <div class="logo-element">
                        {{ $account->alias }}
                    </div>
                </li>

                <li ng-class="{active: $state.includes('admin.pages')}">
                    <a ui-sref="admin.pages.overview"><i class="fa fa-file-text-o"></i>
                        <span class="nav-label">{{ Lang::get('navigation.pages') }}</span></a>
                </li>

                <li ng-class="{active: $state.includes('admin.blog')}">
                    <a ui-sref="admin.blog.posts"><i class="fa fa-newspaper-o"></i>
                        <span class="nav-label">{{ Lang::get('navigation.blog') }}</span></a>
                </li>

                <li ng-class="{active: $state.includes('admin.shop')}">
                    <a href=""><i class="class fa fa-gear"></i> <span class="nav-label">{{ Lang::get('navigation.shop') }}</span></a>
                    <ul class="nav nav-second-level" ng-class="{in: $state.includes('admin.shop')}">
                        <li ui-sref-active="active">
                            <a ui-sref="admin.shop.notifications"><i class="fa fa-bell-o"></i>
                                <span class="nav-label">{{ Lang::get('navigation.notifications') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.shop.categories"><i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">{{ Lang::get('navigation.categories') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.shop.brands"><i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">{{ Lang::get('navigation.brands') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.shop.products"><i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">{{ Lang::get('navigation.products') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.shop.selections"><i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">{{ Lang::get('navigation.selections') }}</span></a>
                        </li>
                    </ul>
                </li>

                <li ng-class="{active: $state.includes('admin.marketing')}">
                    <a href=""><i class="class fa fa fa-money"></i>
                        <span class="nav-label">{{ Lang::get('navigation.marketing') }}</span></a>
                    <ul class="nav nav-second-level" ng-class="{in: $state.includes('admin.marketing')}">
                        <li ui-sref-active="active">
                            <a ui-sref="admin.marketing.campaigns"><i class="fa fa-users"></i>
                                <span class="nav-label">{{ Lang::get('navigation.campaigns') }}</span></a>
                        </li>
                    </ul>
                </li>

                <li ui-sref-active="active">
                    <a ui-sref="admin.portfolio.overview"><i class="fa fa-file-image-o"></i>
                        <span class="nav-label">{{ Lang::get('navigation.portfolio') }}</span></a>
                </li>

                <li ng-class="{active: $state.includes('admin.account')}">
                    <a href=""><i class="class fa fa-gear"></i>
                        <span class="nav-label">{{ Lang::get('navigation.account') }}</span></a>
                    <ul class="nav nav-second-level" ng-class="{in: $state.includes('admin.account')}">
                        <li ui-sref-active="active">
                            <a ui-sref="admin.account.contact"><i class="fa fa-map-marker"></i>
                                <span class="nav-label">{{ Lang::get('navigation.contact') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.account.members"><i class="fa fa-users"></i>
                                <span class="nav-label">{{ Lang::get('navigation.users') }}</span></a>
                        </li>
                        <li ui-sref-active="active">
                            <a ui-sref="admin.account.clients"><i class="fa fa-users"></i>
                                <span class="nav-label">{{ Lang::get('navigation.clients') }}</span></a>
                        </li>
                    </ul>
                </li>

                <li ng-class="{active: $state.includes('admin.theme')}">
                    <a href=""><i class="class fa fa-diamond"></i>
                        <span class="nav-label">{{ Lang::get('navigation.theme') }}</span></a>
                    <ul class="nav nav-second-level" ng-class="{in: $state.includes('admin.theme')}">

                        <li ui-sref-active="active">
                            <a ui-sref="admin.theme.settings"><i class="class fa fa-gear"></i>
                                <span class="nav-label">{{ Lang::get('navigation.settings') }}</span></a>
                        </li>

                        @if($theme)
                            @include($theme->name .'::admin.theme_navigation')
                        @endif

                    </ul>
                </li>
            </ul>

        </div>
    </nav>
</script>
