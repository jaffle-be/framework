@section('styles-header')
<link rel="stylesheet" href="assets/css/headers/header-v2.css">
@stop

@section('header')
    <!--=== Header v2 ===-->
    <div class="header-v2 header-sticky">
        <div class="container container-space">
            <!-- Topbar v2 -->
            <div class="topbar-v2">
                <div class="row">
                    <div class="col-sm-8">
                        <ul class="list-inline top-v2-contacts">
                            <li>Email: <a href="mailto:info@htmlstream.com">info@htmlstream.com</a></li>
                            <li>Call Us: +70 396 4587 99</li>
                            <li>
                                <div class="language-bar">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="heading">Languages</span>
                                    </a>
                                    <ul class="languages-dropdown" role="menu">
                                        <li class="active">
                                            <a href="#">English</a>
                                        </li>
                                        <li><a href="#">Spanish</a></li>
                                        <li><a href="#">Russian</a></li>
                                        <li><a href="#">German</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <div class="topbar-buttons pull-right">
                            <a href="page_login.html" class="btn-u btn-brd btn-brd-hover btn-u-light margin-right-5">Sign In</a>
                            <a href="page_registration.html" class="btn-u">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar v2 -->
        </div>

        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation">
            <div class="container container-space">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a class="navbar-brand brand-style" href="index.html">
                        <img id="logo-header" src="assets/img/logo1-default.png" width="85" height="32" alt="Logo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav">
                        @foreach(Menu::get('primary menu')->items as $item)
                            <li><a href="{{ $item->url }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!--/navbar-collapse-->
            </div>
        </div>
        <!-- End Navbar -->
    </div>
    <!--=== End Header v2 ===-->
@stop