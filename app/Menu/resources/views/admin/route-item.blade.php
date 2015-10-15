<div class="ibox-content ibox-with-footer">

    <div class="alert alert-info">
        if all modules add a records to a linkable routes table, we can use that to add links in the menu
        to for instance our shop home page, or our blog home page

        but we can then use that table to add links within content. this would keep track of things,
        so we can delete links in content of pages or posts or whatever if they were to be deleted.
    </div>

    <div ng-hide="vm.item.id" class="text-center">

        <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

    </div>

    <div class="footer" ng-show="vm.item.id">
        {{ Lang::get('menu::admin.delete-menu-item') }}
        <button class="pull-right btn btn-danger" ng-really="vm.deleteItem()"><i class="fa fa-trash"></i>
        </button>
    </div>
</div>

<script type="text/ng-template" id="/templates/admin/menu/route-item">
    Content of the template.
</script>