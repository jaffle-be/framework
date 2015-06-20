<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-tags') }}</h5>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.tag()" novalidate name="tagForm">

            <div class="form-group col-xs-12 col-md-6">
                <label for="addTag">{{ Lang::get('blog::admin.addTag') }}</label>
                <input type="text" ng-model="asyncSelected" placeholder="{{ Lang::get('blog::admin.tag') }}" typeahead="address for address in getLocation($viewValue)" typeahead-loading="vm.searchingTag" class="form-control">
                <i ng-show="vm.searchingTag" class="glyphicon glyphicon-refresh"></i>
            </div>

            <div class="form-group col-xs-12 col-md-6">
                <input class="btn btn-success" type="submit" value="{{ Lang::get('blog::admin.tag') }}"/>
            </div>

        </form>

        <ul class="nav">
            <li ng-repeat="tag in vm.post.tags">

                <form ng-submit="vm.updateTag(tag)" novalidate name="tagForm">

                    <div class="form-group col-xs-6" ng-repeat="locale in vm.options.locales">
                        <label>@{{ locale.locale }}</label>
                        <input ng-change="vm.updateTag(tag)" class="form-control" type="text" name="@{{ locale.locale }}" ng-model="tag.translations[locale.locale].name"/>
                    </div>

                </form>

                <div class="form-group text-center">
                    <button ng-click="vm.deleteTag(tag.id)" class="btn btn-danger">{{ Lang::get('blog::admin.delete') }}</button>
                </div>

                <div class="clearfix"></div>

            </li>
        </ul>

    </div>

</div>
