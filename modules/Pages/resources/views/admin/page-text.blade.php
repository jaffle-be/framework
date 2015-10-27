
<div class="ibox">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('pages::admin.page.details') }}</h5>
            </div>
            <div class="col-xs-4 text-right">
                <span id="reset" class="btn-sm btn btn-danger" ng-really="vm.delete()"><i class="fa fa-trash"></i></span>
            </div>
        </div>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="postForm" novalidate class="form-horizontal">

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="row">

                <div class="col-xs-8">
                    <div class="form-group col-xs-12">
                        <label for="title" class="control-label">{{ Lang::get('pages::admin.page.title') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.page.translations[vm.options.locale].title"/>
                        </div>
                    </div>

                </div>

                <div class="col-xs-offset-1 col-xs-3">

                    <div class="control-label">&nbsp;</div>

                    <input type="checkbox" class="filled-in" id="published" ng-model="vm.page.translations[vm.options.locale].published" ng-change="vm.save()"/>
                    <label for="published">{{ Lang::get('pages::admin.page.published') }}</label>

                </div>

                <div class="clearfix"></div>

            </div>

            <div class="form-group col-xs-12">
                <label for="slug" class="control-label">{{ Lang::get('pages::admin.page.slug') }}</label>

                <span class="form-control slug" ng-bind="vm.page.translations[vm.options.locale].slug.uri"></span>
            </div>

            <div class="form-group col-xs-12">
                <label for="content" class="control-label">{{ Lang::get('pages::admin.page.content') }}</label>

                <div>
                    <textarea auto-size class="form-control autosize-lg" ng-model="vm.page.translations[vm.options.locale].content" ng-change="vm.save()"></textarea>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>