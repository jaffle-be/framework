<script type="text/ng-template" id="templates/admin/seo/widget">

    <div class="alert alert-info">
        Title and description will also override the title and the description when:

        <ul>
            <li>tweeting about the article</li>
            <li>sharing on google+</li>
            <li>sharing on facebook</li>
        </ul>
    </div>

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

</script>

