<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>500</title>

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

    <link rel="stylesheet" href="{{asset('themes/Unify/assets/css/styles.min.css') }}">

    <!-- CSS page/content level -->
    <link rel="stylesheet" href="{{ asset('themes/Unify/assets/css/pages/page_404_error.css') }}">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('themes/Unify/assets/plugins/line-icons/line-icons.css') }}">
    <link rel="stylesheet" href="{{asset('themes/Unify/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css')}}">

</head>

<body>

<div class="container content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="error-v1">
                <span class="error-v1-title">500</span>
                <span>Hmm, either your or we did something wrong</span>

                <p>In any case, this will be investigated. And, if it would be one of us.. Trust our punishments followed by solutions will prevent this from happening again ;-)</p>
                <a class="btn-u btn-bordered" href="{{ store_route('store.home') }}">Back Home</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>