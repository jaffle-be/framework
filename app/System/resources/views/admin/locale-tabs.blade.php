<div class="ibox">

    <div class="ibox-tabs">

        <tabset ng-show="vm.options.locales.length != 0">
            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.slug }}" {{ isset($clickRefresh) && $clickRefresh ? 'st-click-refresh' : '' }} active="locale.active" select="vm.options.locale = locale.slug">

            </tab>
        </tabset>

    </div>

</div>