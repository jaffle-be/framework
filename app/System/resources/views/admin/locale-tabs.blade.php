<div class="ibox" ng-show="main.multipleLocales(vm.options.locales)">

    <div class="ibox-tabs">

        <tabset>
            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.slug }}" {{ isset($clickRefresh) && $clickRefresh ? 'st-click-refresh' : '' }} active="locale.active" select="vm.options.locale = locale.slug">

            </tab>
        </tabset>

    </div>

</div>