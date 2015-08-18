<div class="row wrapper wrapper-content" ng-controller="PortfolioDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    <tabset>

        <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active" select="vm.options.locale = locale.locale">

        </tab>
    </tabset>

    <div class="col-xs-12 col-lg-7">

        @include('portfolio::admin.project-text')

        @include('portfolio::admin.project-collaborators')

    </div>

    <div class="col-xs-12 col-lg-5" ng-show="vm.project.id">

        @include('portfolio::admin.project-tags')

        @include('portfolio::admin.project-images')

        @include('portfolio::admin.project-client')

    </div>

</div>