<div class="ibox">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('blog::admin.post-details') }}</h5>
            </div>
            <div class="col-xs-4 text-right">
                <span id="publisher" class="btn-sm btn btn-info" ng-click="vm.publish()" ng-show="vm.drafting">{{ Lang::get('blog::admin.drafting') }}</span>
                <span id="reset" class="btn-sm btn btn-danger" ng-click="vm.delete()"><i class="fa fa-trash"></i></span>
            </div>
        </div>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="postForm" novalidate class="form-horizontal">

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="form-group col-xs-12">
                <label for="title" class="control-label">{{ Lang::get('blog::admin.post-title') }}</label>

                <div>
                    <input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.post.translations[vm.options.locale].title"/>
                </div>
            </div>


            <div class="form-group col-xs-12">
                <label for="extract" class="control-label">{{ Lang::get('blog::admin.post-extract') }}</label>

                <div>
                    <div summernote config="vm.options.summernote" ng-model="vm.post.translations[vm.options.locale].extract" on-change="vm.save()"></div>
                </div>
            </div>

            <div class="form-group col-xs-12">
                <label for="content" class="control-label">{{ Lang::get('blog::admin.post-content') }}</label>

                <div>
                    <div summernote config="vm.options.summernote" ng-model="vm.post.translations[vm.options.locale].content" on-change="vm.save()"></div>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>