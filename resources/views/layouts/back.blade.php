<!DOCTYPE html>
<html ng-app="app">

<head>

    <meta charset="utf-8">
    <base href="/admin"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title set in pageTitle directive -->
    <title page-title></title>

    <link id="loadBefore" href="{{ asset('/css/admin/main.css') }}" rel="stylesheet">


</head>

<body ng-controller="MainController as main" class="fixed-sidebar fixed-nav">

<toaster-container toaster-options="main.toaster"></toaster-container>

<div ui-view></div>

<!-- jQuery and Bootstrap -->
<script src=" {{ asset('/js/admin/jquery/jquery-2.1.1.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src=" {{ asset('/js/admin/bootstrap/bootstrap.min.js') }}"></script>


{{--<!-- Custom and plugin javascript -->--}}
<script src=" {{ asset('/js/admin/core.min.js') }}"></script>

{{--<!-- Main Angular scripts-->--}}
<script src=" {{ asset('/js/admin/angular/angular.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-smart-table/smart-table.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/oclazyload/dist/ocLazyLoad.min.js') }}"></script>
<script src=" {{ asset('/js/admin/angular-translate/angular-translate.min.js') }}"></script>
<script src=" {{ asset('/js/admin/ui-router/angular-ui-router.min.js') }}"></script>
<script src=" {{ asset('/js/admin/bootstrap/ui-bootstrap-tpls-0.12.0.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/ngStorage/ngStorage.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/ng-sortable/ng-sortable.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-idle/angular-idle.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-resource/angular-resource.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-cookies/angular-cookies.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-summernote/angular-summernote.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angularjs-toaster/toaster.min.js') }}"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcPQMkol7H0kSnSSqYkJpRicrKfxWHC4o&libraries=places&v=3.exp"></script>

<script src=" {{ asset('/js/admin/app.min.js') }}"></script>
<script src=" {{ asset('/js/admin/config.min.js') }}"></script>
<script src=" {{ asset('/js/admin/services.min.js') }}"></script>
<script src=" {{ asset('/js/admin/translations.min.js') }}"></script>
<script src=" {{ asset('/js/admin/directives.min.js') }}"></script>
<script src=" {{ asset('/js/admin/models.min.js') }}"></script>
<script src=" {{ asset('/js/admin/controllers.min.js') }}"></script>

@if($theme && is_file(public_path('themes/'. $theme->name .'/assets/js/admin/' . $theme->name . '.min.js')))

    <script src=" {{ theme_asset('/js/admin/' . $theme->name .'.min.js') }}"></script>

@else
    {{--mock theme, angular expects this module--}}
    <script type="text/javascript">
        angular.module('theme-active', []);
    </script>

@endif

</body>
</html>
