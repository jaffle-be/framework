<div class="ibox">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('portfolio::admin.project.details') }}</h5>
            </div>
            <div class="col-xs-4">
                <span class="pull-right btn btn-danger btn-sm" ng-really="vm.delete()"><i class="fa fa-trash"></i></span>
            </div>
        </div>
        
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="projectForm" novalidate>

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="row">
                <div class="form-group col-xs-6">
                    <label for="website">{{ Lang::get('portfolio::admin.project.website') }}</label>
                    <input id="website" type="text" class="form-control" ng-model="vm.project.website" ng-change="vm.save()">
                </div>

                <div class="form-group col-xs-4 col-xs-offset-2">

                    <label for="date">{{ Lang::get('portfolio::admin.project.date') }}</label>

                    <div class="input-group datepicker">

                        <input datepicker-popup="dd/MM/yyyy" show-weeks="false" is-open="status.datepickerStatus" type="text" class="form-control" ng-model="vm.project.date" ng-click="vm.openDatepicker($event)" ng-change="vm.save()"/>

                        <div class="input-group-btn">
                                <span type="button" class="btn btn-default" ng-click="vm.openDatepicker($event)">
                                    <i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="control-label">{{ Lang::get('portfolio::admin.project.title') }}</label>

                <div>
                    <input ng-change="vm.save()" type="text" name="title" id="title" class="form-control" ng-model="vm.project.translations[vm.options.locale].title"/>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="control-label">{{ Lang::get('portfolio::admin.project.description') }}</label>

                <div>
                    <div summernote config="vm.options.summernote" ng-model="vm.project.translations[vm.options.locale].description" ng-change="vm.save()"></div>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>