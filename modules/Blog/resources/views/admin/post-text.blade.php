<div class="ibox">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('blog::admin.post.details') }}</h5>
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
                        <label for="title" class="control-label">{{ Lang::get('blog::admin.post.title') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.post.translations[vm.options.locale].title"/>
                        </div>
                    </div>

                </div>

                <div class="col-xs-4">

                    <div class="form-group col-xs-12">

                        <label for="publish_at">{{ Lang::get('blog::admin.post.publish_at') }}</label>

                        <div class="input-group datepicker">

                            <input datepicker-popup="dd/MM/yyyy" show-weeks="false" is-open="status.datepickerStatus" type="text" class="form-control" ng-model="vm.post.translations[vm.options.locale].publish_at" ng-click="vm.openDatepicker($event)" ng-change="vm.save()"/>

                            <div class="input-group-btn">
                                <span type="button" class="btn btn-default" ng-click="vm.openDatepicker($event)">
                                    <i class="fa fa-calendar"></i></span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="clearfix"></div>

            </div>

            <div class="form-group col-xs-12">
                <label for="slug" class="control-label">{{ Lang::get('blog::admin.post.slug') }}</label>

                <span class="form-control slug" ng-bind="vm.post.translations[vm.options.locale].slug.uri"></span>
            </div>

            <div class="form-group col-xs-12">
                <label for="content" class="control-label">{{ Lang::get('blog::admin.post.content') }}</label>

                <div>
                    <textarea auto-size class="form-control autosize-lg" ng-model="vm.post.translations[vm.options.locale].content" ng-change="vm.save()"></textarea>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>