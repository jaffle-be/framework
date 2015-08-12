<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('account::team-creator') }}</h5>
    </div>

    <div class="ibox-content">

        <tabset>

            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active" select="vm.options.locale = locale.locale">

            </tab>
        </tabset>

        <form ng-submit="vm.createNewTeam()">

            <div class="form-group">

                <div class="input-group">

                    <input type="text" class="form-control" autocomplete="off" placeholder="{{ Lang::get('account::admin.new-team') }}" ng-model="vm.newTeamName">

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

                <div summernote config="vm.teamSummernote" ng-model="team.translations[vm.options.locale].description" on-change="vm.updateTeam(team)"></div>
            </li>

        </ul>

    </div>

</div>