<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('portfolio::project-details') }}</h5>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="projectForm" novalidate class="form-horizontal">

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="form-group col-xs-12">
                <label for="title" class="control-label">{{ Lang::get('portfolio::admin.project-title') }}</label>

                <div>
                    <input ng-change="vm.save()" type="text" name="title" id="title" class="form-control" ng-model="vm.project.translations[vm.options.locale].title"/>
                </div>
            </div>

            <div class="form-group col-xs-12">
                <label for="description" class="control-label">{{ Lang::get('portfolio::admin.project-description') }}</label>

                <div>
                    <textarea name="description" ng-change="vm.save()" id="description" cols="30" rows="10" class="form-control" ng-model="vm.project.translations[vm.options.locale].description"></textarea>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>