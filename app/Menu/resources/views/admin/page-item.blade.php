<div class="ibox-content ibox-with-footer">

    <p ng-repeat="page in vm.availablePages">
        <input type="radio" id="page@{{ page.id }}" />
        <label for="page@{{ page.id}}">@{{ page.translations[vm.options.locale].title }}</label>
    </p>

    <div ng-hide="vm.item.id" class="text-center">

        <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

    </div>

    <div class="footer" ng-show="vm.item.id">
        {{ Lang::get('menu::admin.delete-menu-item') }}
        <button class="pull-right btn btn-danger" ng-really="vm.deleteItem()"><i class="fa fa-trash"></i>
        </button>
    </div>
</div>


<script type="text/ng-template" id="/templates/admin/menu/page-item">
    Content of the template.
</script>