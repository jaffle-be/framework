<div class="row wrapper wrapper-content" ng-controller="BlogDetailCtrl as vm" ng-init="vm.options = {{ blog_options() }}">

    <tabset justified="true">

        <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active">

            <div class="col-xs-12 col-md-6 col-lg-8">

                @include('blog::admin.post-text')
            </div>

            <div class="col-xs-12 col-md-6 col-lg-4">

                @include('blog::admin.post-status')

                @include('blog::admin.post-tags')

                @include('blog::admin.post-images')

            </div>

        </tab>
    </tabset>

</div>