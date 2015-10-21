<div menu-route-item="vm.routeItem" menu="vm.menu" locale="vm.options.locale" locales="vm.options.locales">
</div>


<script type="text/ng-template" id="/templates/admin/menu/route-item">

    <div class="ibox-content ibox-with-footer">

        <p ng-repeat="route in menu.availableRoutes">
            <input type="radio" id="route@{{ route.id }}" ng-model="vm.selectedRoute" ng-value="route.id"/>
            <label for="route@{{ route.id}}">@{{ vm.routeName(route) }}</label>
        </p>

        <div class="alert alert-info" ng-show="menu.availableRoutes.length == 0">
            {{ Lang::get('menu::admin.no-more-routes') }}
        </div>

        <div class="text-center">

            <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

        </div>

    </div>

</script>