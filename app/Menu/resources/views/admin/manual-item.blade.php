{{--this vm.item refers to the item in menu controller scope--}}
<div menu-manual-item="vm.item" menu="vm.menu" locales="vm.options.locales">

</div>

{{--vm.item from now on means in the directive scope--}}
<script type="text/ng-template" id="/templates/admin/menu/manual-item">

    <div class="ibox-content ibox-with-footer">

        <div class="form-group" ng-show="!item.page_id">

            <div class="well well-sm">{{ Lang::get('menu::admin.url-explanation') }}</div>

            <label for="url">
                {{ Lang::get('menu::admin.url') }}
            </label>

            <input class="form-control" type="text" name="url" id="url" ng-model="item.url" ng-change="vm.saveItem()"/>

            <div class="checkbox">
                <input type="checkbox" id="target_blank" class="filled-in" ng-model="item.target_blank" ng-change="vm.saveItem(false)">

                <label for="target_blank">{{ Lang::get('menu::admin.target_blank') }}</label>
            </div>

        </div>

        <div ng-repeat="locale in locales">

            <div class="form-group">

                <label for="locale">
                    @{{ locale.slug }}
                </label>

                <input class="form-control" type="text" name="locale" id="locale" ng-model="item.translations[locale.slug].name" ng-change="vm.saveItem()"/>

            </div>

        </div>

        <div ng-hide="item.id" class="text-center">

            <button class="btn btn-primary" ng-click="vm.createItem()">{{ Lang::get('menu::admin.new-item') }}</button>

        </div>


        <div class="footer" ng-show="item.id">
            {{ Lang::get('menu::admin.delete-menu-item') }}
            <button class="pull-right btn btn-danger" ng-really="vm.deleteItem()"><i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</script>