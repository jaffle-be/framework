<div class="row wrapper-content" ng-controller="PortfolioDetailController as vm">

    @include('system::admin.locale-tabs')

    <div class="row">

        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">

            @include('portfolio::admin.project-text')

            @include('portfolio::admin.project-collaborators')

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3" ng-show="vm.project.id">

            @include('portfolio::admin.project-tags')

            @include('portfolio::admin.project-images')

            @include('portfolio::admin.project-client')

        </div>

    </div>
</div>
