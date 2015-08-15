<form ng-submit="ctrl.createTag()" novalidate name="tagForm">

    <div class="form-group">

        <div class="input-group">

            <div class="input-group-addon">
                <i class="fa fa-refresh" ng-show="searching"></i><i class="fa fa-search" ng-hide="searching"></i></div>

            <input type="text" class="form-control" placeholder="{{ Lang::get('blog::admin.tag') }}"
                   typeahead="tag.translations[locale].name for tag in ctrl.searchTag($viewValue, locale)"
                   typeahead-loading="searching"
                   typeahead-on-select="ctrl.addTag($item, $model, $label)"
                   ng-model="input">

            <div class="input-group-btn">
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
            </div>

        </div>

    </div>

</form>

<div class="clearfix"></div>

<ul class="nav">
    <li ng-repeat="tag in tags">

        <form ng-submit="ctrl.updateTag(tag)" novalidate name="tagForm">

            <div class="form-group">

                <div class="input-group">
                    <input autocomplete="off" ng-change="ctrl.updateTag(tag)" class="form-control" type="text" name="@{{ locale }}" ng-model="tag.translations[locale].name"/>

                    <div class="input-group-btn">
                        <button ng-click="ctrl.deleteTag(tag)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                </div>

            </div>

        </form>

    </li>
</ul>