<div class="ibox" ng-show="vm.editingTeams">

    <div class="ibox-title">
        <h5>{{ Lang::get('account::admin.team.create') }}</h5>
        <button class="btn btn-info btn-xs pull-right" ng-click="vm.closeTeamEditor()"><i class="fa fa-remove"></i></button>
        <div class="clearfix"></div>
    </div>

    <div class="ibox-content">

        @include('system::admin.locale-tabs')

        <form ng-submit="vm.createNewTeam()">

            <div class="form-group">

                <div class="input-group">

                    <input type="text" class="form-control" autocomplete="off" placeholder="{{ Lang::get('account::admin.team.new-team') }}" ng-model="vm.newTeamName">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>

                </div>

            </div>

        </form>

        <hr>

        <ul class="nav team-list">

            <li ng-repeat="team in vm.teams">

                <div class="form-group">

                    <div class="input-group">
                        <input type="text" class="form-control" ng-model="team.translations[vm.options.locale].name" ng-change="vm.updateTeam(team)">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-danger" ng-click="vm.deleteTeam(team)"><i class="fa fa-trash"></i></button>
                        </div>

                    </div>
                </div>

                <div summernote config="vm.options.summernote" ng-model="team.translations[vm.options.locale].description" ng-change="vm.updateTeam(team)"></div>
            </li>

        </ul>

    </div>

</div>