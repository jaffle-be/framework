<!-- Wrapper-->
<div id="wrapper">

    <!-- Navigation -->
    <div ng-include="'admin/templates/navigation'"></div>

    <!-- Page wraper -->
    <!-- ng-class with current state name give you the ability to extended customization your view -->
    <div id="page-wrapper" class="gray-bg @@{{$state.current.name}}">

        <!-- Page wrapper -->
        <div ng-include="'admin/templates/topnavbar'"></div>

        <!-- Main view  -->
        <div ui-view></div>

        <!-- Footer -->
        <div ng-include="'admin/templates/footer'"></div>

    </div>
    <!-- End page wrapper-->

    <!-- Right Sidebar -->
    <div ng-include="'admin/templates/right_sidebar'"></div>

</div>
<!-- End wrapper-->