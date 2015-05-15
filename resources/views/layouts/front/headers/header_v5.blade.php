@section('styles-header')
    <link rel="stylesheet" href="{{ asset('assets/css/headers/header-v5.css') }}">
@stop

@section('header')
    <!--=== Header v5 ===-->
    <div class="header-v5">
        <!-- Topbar v3 -->
        <div class="topbar-v3">
            <div class="search-open">
                <div class="container">
                    <input type="text" class="form-control" placeholder="Search">

                    <div class="search-close"><i class="icon-close"></i></div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Topbar Navigation -->
                        <ul class="left-topbar">
                            <li>
                                <a>Currency (USD)</a>
                                <ul class="currency">
                                    <li class="active">
                                        <a href="#">USD <i class="fa fa-check"></i></a>
                                    </li>
                                    <li><a href="#">Euro</a></li>
                                    <li><a href="#">Pound</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Language (EN)</a>
                                <ul class="language">
                                    <li class="active">
                                        <a href="#">English (EN)<i class="fa fa-check"></i></a>
                                    </li>
                                    <li><a href="#">Spanish (SPN)</a></li>
                                    <li><a href="#">Russian (RUS)</a></li>
                                    <li><a href="#">German (GRM)</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!--/end left-topbar-->
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-inline right-topbar pull-right">
                            <li><a href="#">Account</a></li>
                            <li><a href="shop-ui-add-to-cart.html">Wishlist (0)</a></li>
                            <li><a href="shop-ui-login.html">Login</a> | <a href="shop-ui-register.html">Register</a>
                            </li>
                            <li><i class="search fa fa-search search-button"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/container-->
        </div>
        <!-- End Topbar v3 -->

        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">
                        <img id="logo-header" src="{{ asset('/assets/img/logo1-default.png') }}" alt="Logo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <!-- Badge -->
                    <ul class="list-inline shop-badge badge-lists badge-icons pull-right">
                        <li>
                            <a href="#"><i class="fa fa-shopping-cart"></i></a>
                            <span class="badge badge-sea rounded-x">3</span>
                            <ul class="list-unstyled badge-open" data-mcs-theme="minimal-dark">
                                <li class="subtotal">
                                    <div class="overflow-h margin-bottom-10">
                                        <p>NO PRODUCTS IN THE CART</p>
                                        <hr class="hr-xs">
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a href="shop-ui-inner.html" class="btn-u btn-brd btn-brd-hover btn-u-sea-shop btn-block">View Cart</a>
                                        </div>
                                        <div class="col-xs-6 text-right padding-top-5">
                                            <strong>TOTAL: $0.00</strong>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- End Badge -->

                    <ul class="nav navbar-nav">
                        @foreach(Menu::get('primary menu')->items as $item)
                            @if($item->children->count() == 0)
                                <li><a href="{{ $item->url }}">{{ $item->name }}</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach($item->children as $child)
                                            <li><a href="{{ $child->url }}">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <!--/navbar-collapse-->
            </div>
        </div>
        <!-- End Navbar -->
    </div>
    <!--=== End Header v5 ===-->
@stop