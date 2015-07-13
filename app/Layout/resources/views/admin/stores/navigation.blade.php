<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul side-navigation class="nav" id="side-menu">
            <li class="nav-header">

                <div class="dropdown profile-element" dropdown>
                    <img alt="image" class="img-circle" src="img/profile_small.jpg"/>
                    <a class="dropdown-toggle" dropdown-toggle href>
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">David Williams</strong>
                             </span>
                                <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                            </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a ui-sref="profile">Profile</a></li>
                        <li><a ui-sref="contacts">Contacts</a></li>
                        <li><a ui-sref="inbox">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="../login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            
            <li ui-sref-active="active">
                <a ui-sref="admin.start"><i class="fa fa-tachometer"></i> <span class="nav-label">@{{ 'DASH' | translate }}</span></a>
            </li>
            <li ng-class="{active: $state.includes('admin.blog')}">
                <a ui-sref="admin.blog.posts"><i class="fa fa-newspaper-o"></i> <span class="nav-label">@{{ 'BLOG' | translate }}</span></a>
            </li>

            <li ui-sref-active="active">
                <a ui-sref="admin.products"><i class="fa fa-newspaper-o"></i> <span class="nav-label">@{{ 'SHOP' | translate }}</span></a>
            </li>

            <li ng-class="{active: $state.includes('admin.marketing')}">
                <a ui-sref="admin.marketing.overview"><i class="fa fa-money"></i> <span class="nav-label">@{{ 'MARKETING' | translate }}</span></a>
            </li>

            <li ng-class="{active: $state.includes('admin.account')}">
                <a href=""><i class="class fa fa-gear"></i> <span class="nav-label">@{{ 'ACCOUNT' | translate }}</span></a>
                <ul class="nav nav-second-level" ng-class="{in: $state.includes('admin.account')}">
                    <li ui-sref-active="active">
                        <a ui-sref="admin.account.contact"><i class="class fa fa-map-marker"></i> <span class="nav-label">@{{ 'CONTACT' | translate }}</span></a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>