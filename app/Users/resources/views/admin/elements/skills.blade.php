
<form ng-submit="vm.createSkill()" novalidate name="skillForm">

    <div class="form-group">

        <div class="input-group">

            <div class="input-group-addon">
                <i class="fa fa-refresh" ng-show="searching"></i><i class="fa fa-search" ng-hide="searching"></i></div>

            <input type="text" class="form-control" placeholder="{{ Lang::get('users::admin.skill.skill') }}"
                   typeahead="skill.translations[vm.options.locale].name for skill in vm.searchSkill($viewValue, vm.options.locale)"
                   typeahead-loading="searching"
                   typeahead-on-select="vm.addSkill($item, $model, $label)"
                   ng-model="vm.input">

            <div class="input-group-btn">
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
            </div>

        </div>

    </div>

</form>

<div class="clearfix"></div>

<ul class="nav profile-skills">
    <li class="profile-skill" ng-repeat="skill in vm.profile.skills">

        <form ng-submit="vm.updateSkill(skill)" novalidate name="skillForm">

                <div class="form-group col-xs-8">

                    <div class="input-group">
                        <input autocomplete="off" ng-change="vm.updateSkill(skill)" class="form-control" type="text" ng-model="skill.translations[vm.options.locale].name"/>

                        <span class="input-group-btn">
                            <button ng-click="vm.deleteSkill(skill)" class="btn btn-danger"><i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>

                </div>

                <div class="form-group col-xs-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Lang::get('users::admin.skill.level') }}
                        </span>
                        <input type="text" name="level" id="level" class="form-control" ng-model="skill.pivot.level" ng-change="vm.updateSkill(skill)"/>

                        <span class="input-group-addon">
                            %
                        </span>
                    </div>
                </div>

            <div class="form-group col-xs-12">

                <div class="form-group">
                    <label for="">{{ Lang::get('users::admin.skill.description') }}</label>
                    <div summernote config="vm.options.summernote" ng-model="skill.translations[vm.options.locale].description" ng-change="vm.updateSkill(skill)"></div>
                </div>

            </div>

        </form>

        <div class="clearfix"></div>

    </li>
</ul>