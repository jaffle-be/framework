<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>@yield('title')</title>

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
    <link rel="stylesheet" href="{{asset('css/front/main.min.css') }}">

    @section('styles-style')
        <link rel="stylesheet" href="{{asset('themes/Unify/assets/css/styles.min.css') }}">
        @show

                <!-- CSS page/content level -->
        @yield('styles-content')

                <!-- CSS Implementing Plugins -->
    @section('styles-plugins')
        <link rel="stylesheet" href="{{asset('themes/Unify/assets/plugins/line-icons/line-icons.css') }}">
        <link rel="stylesheet" href="{{asset('themes/Unify/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css')}}">
    @show

</head>

<body>

@yield('content')

        <!-- JS Global Compulsory -->
<script src="{{ asset('themes/Unify/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('themes/Unify/assets/plugins/jquery/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('themes/Unify/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- JS Implementing Plugins -->
@section('scripts-plugins')
    <script src="{{asset('themes/Unify/assets/plugins/back-to-top.js')}}"></script>
    <script src="{{asset('themes/Unify/assets/plugins/smoothScroll.js')}}"></script>
    <script src="{{asset('themes/Unify/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    @show

            <!-- JS Customization -->
    <script type="text/javascript" src="{{ asset('themes/Unify/assets/js/custom.js') }}"></script>

    <!-- JS Page Level -->
@section('scripts-app')
    <script src="{{ asset('themes/Unify/assets/js/app.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
        });
    </script>
    @show

@yield('scripts-footer')

<!--[if lt IE 9]>
    <script src="{{ asset('themes/Unify/assets/plugins/respond.js') }}"></script>
    <script src="{{ asset('themes/Unify/assets/plugins/html5shiv.js') }}"></script>
    <script src="{{ asset('themes/Unify/assets/plugins/placeholder-IE-fixes.js') }}"></script>
    <script src="{{ asset('themes/Unify/assets/plugins/sky-forms-pro/skyforms/js/sky-forms-ie8.js') }}"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="{{ asset('themes/Unify/assets/plugins/sky-forms-pro/skyforms/js/jquery.placeholder.min.js')}}"></script>
    <![endif]-->
</body>
</html>