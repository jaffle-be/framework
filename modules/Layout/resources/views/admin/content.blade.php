<!-- Wrapper-->
<div id="wrapper">

    <!-- Navigation -->
    <div ng-include="'templates/admin/layout/navigation'"></div>

    <!-- Page wraper -->
    <!-- ng-class with current state name give you the ability to extended customization your view -->
    <div id="page-wrapper" class="gray-bg @{{$state.current.name}}">

        <!-- Page wrapper -->
        <div ng-include="'templates/admin/layout/topnavbar'"></div>

        <!-- Main view  -->
        <div ui-view></div>

        <!-- Footer -->
        <div ng-include="'templates/admin/layout/footer'"></div>

    </div>
    <!-- End page wrapper-->

</div>
<!-- End wrapper-->

@include('layout::admin.navigation')
@include('layout::admin.topnavbar')
@include('layout::admin.footer')