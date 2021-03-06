<script type="text/ng-template" id="templates/admin/layout/topnavbar">
    <div class="row border-bottom">
        <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <span minimalize-sidebar></span>

                <form role="search" class="navbar-form-custom" method="post" action="views/search_results.html">
                    <div class="form-group">
                        <input type="text" placeholder="{{ Lang::get('navigation.search') }}" class="form-control"
                               name="top-search" id="top-search">
                    </div>
                </form>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="{{ store_route('store.auth.signout.index') }}" target="_self">
                        <i class="fa fa-sign-out"></i> {{ Lang::get('layout::admin.logout') }}
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</script>
