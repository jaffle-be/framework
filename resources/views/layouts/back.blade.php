<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= asset('css/main.css') ?>"/>
</head>
<body>

@include('layouts.back.header')

<div id="layout-wrapper">
    @include('layouts.back.sidebar')

    <div id="layout-content">
        @include('layouts.back.content')
    </div>
</div>

@include('layouts.back.footer')

<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
</body>
</html>