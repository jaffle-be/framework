<tab heading="{{ Lang::get('pages::admin.page.sub_pages') }}">

    <div class="ibox-content">

        <subpage-input locale="vm.options.locale" page="vm.page"></subpage-input>

    </div>

</tab>


<script type="text/ng-template" id="/templates/admin/pages/widget">

    <div class="selected-subpages">

        <h5>{{ Lang::get('pages::admin.selected-subpages') }}</h5>

        <div class="alert alert-info" ng-hide="page.children.length">{{ Lang::get('pages::admin.no-selected-pages') }}</div>

        <ul ng-show="page.children.length">
            <li ng-repeat="child in page.children">
                <span class="sortable-item-handle"><i class="fa fa-arrows"></i></span>
                @{{ child.translations[locale].title }}
                <button class="btn btn-warning" ng-click="vm.removePage(child)"><i class="fa fa-trash"></i></button>
            </li>
        </ul>
    </div>

    <div class="available-subpages">

        <h5>{{ Lang::get('pages::admin.available-subpages') }}</h5>

        <div class="alert alert-info" ng-hide="page.availablePages.length">{{ Lang::get('pages::admin.no-more-pages') }}</div>

        <div ng-show="page.availablePages.length">
            <ul class="nav">
                <li ng-repeat="child in page.availablePages">
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