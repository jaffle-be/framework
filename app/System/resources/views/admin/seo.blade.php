<div class="form-group">

    <label for="">{{ Lang::get('system::admin.seo.title') }}</label>

    <input type="text" class="form-control" ng-model="seo[locale].title" ng-change="ctrl.updateSeo()">

</div>

<div class="form-group">

    <label for="">{{ Lang::get('system::admin.seo.description') }}</label>

    <textarea rows="2" class="form-control" ng-model="seo[locale].description" ng-change="ctrl.updateSeo()"></textarea>

</div>

<div class="form-group">

    <label for="">{{ Lang::get('system::admin.seo.keywords') }}</label>

    <input type="text" class="form-control" ng-model="seo[locale].keywords" ng-change="ctrl.updateSeo()">

</div>