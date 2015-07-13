<div class="row wrapper wrapper-content" ng-controller="BlogDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    <tabset justified="true">

        <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active">

            <div class="col-xs-12 col-lg-7">

                @include('blog::admin.post-text')

            </div>

            <div class="col-xs-12 col-lg-5" ng-show="vm.post.id">

                @include('blog::admin.post-tags')

                @include('blog::admin.post-images')

            </div>

        </tab>
    </tabset>

</div>