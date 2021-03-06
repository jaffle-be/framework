<!DOCTYPE html>
<html ng-app="app">

<head>

    <meta charset="utf-8">
    <base href="/admin"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title set in pageTitle directive -->
    <title page-title></title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&lang=en">
    <link id="loadBefore" href="{{ asset('/css/admin/main.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

</head>

<body ng-controller="MainController as main" class="fixed-sidebar fixed-nav skin-1">

<toaster-container toaster-options="main.toaster"></toaster-container>

<div ui-view></div>

<script type="text/ng-template" id="confirmModal.html">
    <div class="modal-body">{{ Lang::get('navigation.are-you-sure') }}</div>;
    <div class="modal-footer"><button class="btn btn-warning" ng-click="ok()">{{ Lang::get('navigation.do') }}</button><button class="btn btn-default" ng-click="cancel()">{{ Lang::get('navigation.cancel') }}</button></div>
</script>

<script type="text/ng-template" id="reallyModal.html">
<div class="modal-body">{{ Lang::get('navigation.are-you-sure') }}</div>
<div class="modal-footer"><button class="btn btn-danger" ng-click="ok()">{{ Lang::get('navigation.remove') }}</button><button class="btn btn-default" ng-click="cancel()">{{ Lang::get('navigation.cancel') }}</button></div>
</script>


<script src=" {{ asset('/js/admin/core.min.js') }}"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcPQMkol7H0kSnSSqYkJpRicrKfxWHC4o&libraries=places&v=3.exp"></script>

<script type="text/javascript" src="{{ asset('/js/admin/all.min.js') }}"></script>

@if($theme && is_file(public_path('themes/'. $theme->name .'/assets/js/admin/' . lcfirst($theme->name) . '.min.js')))

    <script src=" {{ theme_asset('/js/admin/' . lcfirst($theme->name .'.min.js')) }}"></script>

@else
    {{--mock theme, angular expects this module--}}
    <script type="text/javascript">
        angular.module('theme-active', []);
    </script>

@endif

</body>
</html>
