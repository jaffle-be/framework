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

    @section('styles-style')
        <link rel="stylesheet" href="{{asset('/assets/css/style.css') }}">
    @show

    {{--we preinclude the header and footer here so we can adjust the styles and scripts accordingly in the proper sections of the html--}}
    {{--if we didn't do this, styles would not be in the head section, thus slowing down the site.--}}
    @include('layouts.front.headers.header_v5')
    @include('layouts.front.footers.footer_default')


    <!-- CSS Header and Footer -->
    @yield('styles-header')
    @yield('styles-content')
    @yield('styles-footer')

    <!-- CSS Implementing Plugins -->
    @section('styles-plugins')
        <link rel="stylesheet" href="{{asset('/assets/plugins/animate.css') }}">
        <link rel="stylesheet" href="{{asset('/assets/plugins/line-icons/line-icons.css') }}">
        <link rel="stylesheet" href="{{asset('/assets/plugins/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{asset('/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css')}}">
    @show

    <!-- CSS Theme -->
    <link rel="stylesheet" href="{{asset('/assets/css/theme-colors/default.css') }}">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="{{asset('/css/front/main.css') }}">
</head>

<body class="header-fixed">

<div class="wrapper">

    @yield('header')

    @yield('slider')

    @yield('breadcrumb')

    @yield('content')

    @yield('footer')

</div>


<!-- JS Global Compulsory -->
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- JS Implementing Plugins -->
@section('scripts-plugins')
    <script src="{{asset('/assets/plugins/back-to-top.js')}}"></script>
    <script src="{{asset('/assets/plugins/smoothScroll.js')}}"></script>
    <script src="{{asset('/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@show

<!-- JS Customization -->
<script type="text/javascript" src="{{ asset('/assets/js/custom.js') }}"></script>

<!-- JS Page Level -->
@section('scripts-app')
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
        });
    </script>
@show

<!--[if lt IE 9]>
<script src="{{ asset('/assets/plugins/respond.js') }}"></script>
<script src="{{ asset('/assets/plugins/html5shiv.js') }}"></script>
<script src="{{ asset('/assets/plugins/placeholder-IE-fixes.js') }}"></script>
<script src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/sky-forms-ie8.js') }}"></script>
<![endif]-->
<!--[if lt IE 10]>
<script src="{{ asset('/assets/plugins/sky-forms-pro/skyforms/js/jquery.placeholder.min.js')}}"></script>
<![endif]-->
</body>
</html>