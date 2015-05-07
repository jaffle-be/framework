<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>front layout</title>

    <link rel="stylesheet" href="<?= asset('css/main.css') ?>"/>
</head>
<body>

@include('layouts.front.header')

<div id="layout-wrapper">
    @include('layouts.front.content')
</div>

@include('layouts.front.footer')

<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
</body>
</html>