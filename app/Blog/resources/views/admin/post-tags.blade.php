<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-tags') }}</h5>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.createTag()" novalidate name="tagForm">

            <div class="form-group">

                <div class="input-group">

                    <div class="input-group-addon"><i class="fa fa-refresh" ng-show="vm.tags.searching"></i><i class="fa fa-search" ng-hide="vm.tags.searching"></i></div>

                    <input type="text" class="form-control" placeholder="{{ Lang::get('blog::admin.tag') }}"
                           typeahead="tags.translations[locale.locale].name for tags in vm.searchTag($viewValue, locale.locale)"
                           typeahead-loading="vm.tags.searching"
                           typeahead-on-select="vm.addTag($item, $model, $label)"
                           ng-model="vm.tags.input">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>

                </div>

            </div>

        </form>

        <div class="clearfix"></div>

        <ul class="nav">
            <li ng-repeat="tag in vm.post.tags">

                <form ng-submit="vm.updateTag(tag)" novalidate name="tagForm">

                    <div class="form-group">

                        <div class="input-group">
                            <input ng-change="vm.updateTag(tag)" class="form-control" type="text" name="@{{ locale.locale }}" ng-model="tag.translations[locale.locale].name"/>

                            <div class="input-group-btn">
                                <button ng-click="vm.deleteTag(tag.id)" class="btn btn-danger"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                    </div>

                </form>

            </li>
        </ul>

    </div>

</div>
