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

            <li><a href="#">if user has rights</a></li>
            <li ui-sref-active="active">
                <a ui-sref="admin.products" href=""><i class="fa fa-barcode"></i><span class="nav-label">@{{ 'PRODUCTS' | translate }}</span></a>
            </li>

            <li ui-sref-active="active">
                <a ui-sref="admin.blog"><i class="fa fa-newspaper-o"></i> <span class="nav-label">@{{ 'BLOG' | translate }}</span></a>
            </li>
        </ul>

    </div>
</nav>