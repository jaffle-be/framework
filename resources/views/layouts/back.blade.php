
<!DOCTYPE html>
<html ng-app="app">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title set in pageTitle directive -->
    <title page-title></title>

    <link id="loadBefore" href="{{ asset('/css/admin/main.css') }}" rel="stylesheet">


</head>

<body ng-controller="MainCtrl as main" class="fixed-sidebar fixed-nav">

<div ui-view></div>

<!-- jQuery and Bootstrap -->
<script src=" {{ asset('/js/admin/jquery/jquery-2.1.1.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src=" {{ asset('/js/admin/bootstrap/bootstrap.min.js') }}"></script>


{{--<!-- Custom and plugin javascript -->--}}
<script src=" {{ asset('/js/admin/core.min.js') }}"></script>

{{--<!-- Main Angular scripts-->--}}
<script src=" {{ asset('/js/admin/angular/angular.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/oclazyload/dist/ocLazyLoad.min.js') }}"></script>
<script src=" {{ asset('/js/admin/angular-translate/angular-translate.min.js') }}"></script>
<script src=" {{ asset('/js/admin/ui-router/angular-ui-router.min.js') }}"></script>
<script src=" {{ asset('/js/admin/bootstrap/ui-bootstrap-tpls-0.12.0.min.js') }}"></script>
<script src=" {{ asset('/js/admin/plugins/angular-idle/angular-idle.js') }}"></script>

<!--
 You need to include this script on any page that has a Google Map.
 When using Google Maps on your own site you MUST signup for your own API key at:
 https://developers.google.com/maps/documentation/javascript/tutorial#api_key
 After your sign up replace the key in the URL below..
-->
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70"></script>--}}

<script src=" {{ asset('/js/' . app_detect() . '/admin/app.min.js') }}"></script>
<script src=" {{ asset('/js/' . app_detect() . '/admin/config.min.js') }}"></script>
<script src=" {{ asset('/js/' . app_detect() . '/admin/services.min.js') }}"></script>
<script src=" {{ asset('/js/' . app_detect() . '/admin/translations.min.js') }}"></script>
<script src=" {{ asset('/js/' . app_detect() . '/admin/directives.min.js') }}"></script>
<script src=" {{ asset('/js/' . app_detect() . '/admin/controllers.min.js') }}"></script>

</body>
</html>
