<tab>

    <tab-heading>
        <i class="fa fa-map-signs"></i>
    </tab-heading>

    <div class="ibox-content">

        <subpage-input locale="vm.options.locale" page="vm.page"></subpage-input>

    </div>

</tab>


<script type="text/ng-template" id="/templates/admin/pages/widget">

    <div class="selected-subpages">

        <h5>{{ Lang::get('pages::admin.selected-subpages') }}</h5>

        <div class="alert alert-info" ng-hide="vm.parentPage.children.length">{{ Lang::get('pages::admin.no-selected-pages') }}</div>

        <ul as-sortable="vm.sortables" ng-model="vm.parentPage.children">
            <li ng-repeat="child in vm.parentPage.children" as-sortable-item>
                <span class="sortable-item-handle" as-sortable-item-handle><i class="fa fa-arrows"></i></span>
                @{{ child.translations[locale].title }}
                <button class="btn btn-warning" ng-click="vm.removePage(child)"><i class="fa fa-trash"></i></button>
            </li>
        </ul>
    </div>

    <div class="available-subpages">

        <h5>{{ Lang::get('pages::admin.available-subpages') }}</h5>

        <div class="alert alert-info" ng-hide="vm.parentPage.availablePages.length">{{ Lang::get('pages::admin.no-more-pages') }}</div>

        <div ng-show="vm.parentPage.availablePages.length">
            <ul class="nav">
                <li ng-repeat="child in vm.parentPage.availablePages">
                    <input type="radio" id="child@{{ child.id }}" ng-model="vm.addingPage" ng-value="child"/>
                    <label for="child@{{ child.id }}">@{{ child.translations[locale].title }}</label>
                </li>
            </ul>

            <div class="text-center">
                <button class="btn btn-primary" ng-click="vm.addPage()">{{ Lang::get('pages::admin.add-page') }}</button>
            </div>
        </div>

    </div>

</script>