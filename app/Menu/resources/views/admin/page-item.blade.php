<div menu-page-item="vm.pageItem" menu="vm.menu" locale="vm.options.locale" locales="vm.options.locales">
</div>


<script type="text/ng-template" id="/templates/admin/menu/page-item">

    <div class="ibox-content ibox-with-footer">

        <p ng-repeat="page in menu.availablePages">
            <input type="radio" id="page@{{ page.id }}" ng-model="vm.selectedPage" ng-value="page.id"/>
            <label for="page@{{ page.id}}">@{{ vm.pageName(page) }}</label>
        </p>

        <div class="alert alert-info" ng-show="menu.availablePages.length == 0">
            {{ Lang::get('menu::admin.no-more-pages') }}
        </div>

        <div class="text-center">

            <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

        </div>

    </div>

</script>