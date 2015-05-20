
<!DOCTYPE html>
<html ng-app="app">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title set in pageTitle directive -->
    <title page-title></title>

    <link id="loadBefore" href="{{ asset('/css/main.css') }}" rel="stylesheet">


</head>

<body ng-controller="MainCtrl as main">

<div ui-view></div>

<script src="{{ asset('/js/admin/core.js') }}"></script>

<!--
 You need to include this script on any page that has a Google Map.
 When using Google Maps on your own site you MUST signup for your own API key at:
 https://developers.google.com/maps/documentation/javascript/tutorial#api_key
 After your sign up replace the key in the URL below..
-->
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70"></script>--}}

<script src=" {{ asset('/js/admin/app.min.js') }}"></script>
<script src=" {{ asset('/js/admin/config.min.js') }}"></script>
<script src=" {{ asset('/js/admin/translations.min.js') }}"></script>
<script src=" {{ asset('/js/admin/directives.min.js') }}"></script>
<script src=" {{ asset('/js/admin/controllers.min.js') }}"></script>

</body>
</html>
