@section('styles-header')
    <link rel="stylesheet" href="assets/css/headers/header-v3.css">
@stop

@section('header')

<div class="header-v3">
    <!-- Navbar -->
    <div class="navbar navbar-default mega-menu" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img id="logo-header" src="assets/img/logo1-default.png" alt="Logo">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
                <div class="container">
                    <ul class="nav navbar-nav">

                        @foreach(Menu::get('primary menu')->items as $item)
                            <li><a href="{{ $item->url }}">{{ $item->name }}</a></li>
                        @endforeach

                        <!-- Search Block -->
                        <li>
                            <i class="search fa fa-search search-btn"></i>

                            <div class="search-open">
                                <div class="input-group animated fadeInDown">
                                    <input type="text" class="form-control" placeholder="Search">
                                        <span class="input-group-btn">
                                            <button class="btn-u" type="button">Go</button>
                                        </span>
                                </div>
                            </div>
                        </li>
                        <!-- End Search Block -->
                    </ul>
                </div>
                <!--/end container-->
            </div>
            <!--/navbar-collapse-->
        </div>
    </div>
    <!-- End Navbar -->
</div>
<!--=== End Header v3 ===-->
@stop