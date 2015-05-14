@section('styles-header')
    <link rel="stylesheet" href="assets/css/headers/header-v6.css">
@stop
        @section('header')
    <!--=== Header v6 ===-->
    <div class="header-v6 header-classic-dark header-sticky">
        <!-- Navbar -->
        <div class="navbar mega-menu" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="menu-container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Navbar Brand -->
                    <div class="navbar-brand">
                        <a href="index.html">
                            <img class="default-logo" src="assets/img/logo3-light.png" alt="Logo">
                        </a>
                    </div>
                    <!-- ENd Navbar Brand -->

                    <!-- Header Inner Right -->
                    <div class="header-inner-right">
                        <ul class="menu-icons-list">
                            <li class="menu-icons shopping-cart">
                                <i class="menu-icons-style radius-x fa fa-shopping-cart"></i>
                                <span class="badge">0</span>
                                <div class="shopping-cart-open">
                                    <span class="shc-title">No products in the Cart</span>
                                    <button type="button" class="btn-u"><i class="fa fa-shopping-cart"></i> Cart</button>
                                    <span class="shc-total">Total: <strong>$0.00</strong></span>
                                </div>
                            </li>
                            <li class="menu-icons">
                                <i class="menu-icons-style search search-close search-btn fa fa-search"></i>
                                <div class="search-open">
                                    <input type="text" class="animated fadeIn form-control" placeholder="Start searching ...">
                                </div>
                            </li>
                        </ul>    
                    </div>
                    <!-- End Header Inner Right -->
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <div class="menu-container">
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
                </div><!--/navbar-collapse-->
            </div>    
        </div>            
        <!-- End Navbar -->
    </div>
    <!--=== End Header v6 ===-->
@stop