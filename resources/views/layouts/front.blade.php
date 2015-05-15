<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>Unify - Responsive Website Template</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Web Fonts -->
    <link rel="shortcut" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=cyrillic,latin">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('/assets/css/style.css') }}">

    {{--we preinclude the header and footer here so we can adjust the styles and scripts accordingly in the proper sections of the html--}}
    {{--if we didn't do this, styles would not be in the head section, thus slowing down the site.--}}
    @include('layouts.front.headers.header_v2')
    @include('layouts.front.footers.footer_default')


    <!-- CSS Header and Footer -->
    @yield('styles-header')
    @yield('styles-content')
    @yield('styles-footer')

                <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{asset('/assets/plugins/animate.css') }}">
        <link rel="stylesheet" href="{{asset('/assets/plugins/line-icons/line-icons.css') }}">
        <link rel="stylesheet" href="{{asset('/assets/plugins/font-awesome/css/font-awesome.css') }}">

        <!-- CSS Theme -->
        <link rel="stylesheet" href="{{asset('/assets/css/theme-colors/default.css') }}">

        <!-- CSS Customization -->
        <link rel="stylesheet" href="{{asset('/assets/css/custom.css') }}">
</head>

<body class="header-fixed">

<div class="wrapper">

    {{--HEADER--}}
    @yield('header')

    <!-- Image Gradient -->
    <div class="interactive-slider-v2">
        <div class="container">
            <h1>Welcome to Unify</h1>
            <p>Clean and fully responsive Template.</p>
        </div>
    </div>
    <!-- End Image Gradient -->
    @yield('content')

    @yield('footer')

</div>


<!-- JS Global Compulsory -->
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- JS Implementing Plugins -->
@yield('scripts-header')
@yield('scripts-content')
@yield('scripts-footer')

<!-- JS Customization -->
<script type="text/javascript" src="{{ asset('/assets/js/custom.js') }}"></script>

<!-- JS Page Level -->
<script src="{{ asset('/assets/js/app.js') }}"></script>
<script>
    jQuery(document).ready(function () {
        App.init();
    });
</script>

<!--[if lt IE 9]>
<script src="{{ asset('/assets/plugins/respond.js') }}"></script>
<script src="{{ asset('/assets/plugins/html5shiv.js') }}"></script>
<script src="{{ asset('/assets/plugins/placeholder-IE-fixes.js') }}"></script>
<![endif]-->
</body>
</html>