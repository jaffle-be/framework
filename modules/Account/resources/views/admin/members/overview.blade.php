<div class="row wrapper-content" ng-controller="MembershipsController as vm"
     ng-init="vm.options = {{ system_options() }}">

    <div class="row">

        <div class="col-md-4">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::admin.users.send-invite') }}</h5>
                </div>

                <div class="ibox-content">

                    <div class="form-group">

                        <ul class="invitations">
                            <li ng-repeat="invitation in vm.invitations">
                                <a class="pull-right btn btn-danger" ng-really="vm.revokeInvitation(invitation)"><i
                                        class="fa fa-trash"></i></a>
                                @{{ invitation.email }} <br>
                                {{ Lang::get('account::admin.users.since') }}: @{{ invitation.created_at | fromNow }}
                            </li>
                        </ul>

                        <br>

                        <form name="invitationForm">
                            <input autocomplete="off" class="form-control" type="text" name="email" id="email"
                                   placeholder="{{ Lang::get('account::admin.users.email') }}"/>

                        </form>

                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-lg"
                                ng-click="vm.sendInvitation()">{{ Lang::get('account::admin.users.send') }}</button>
                    </div>

                    <input-errors errors="vm.invitationErrors"></input-errors>

                </div>

            </div>

        </div>

        <div class="col-md-8">

            @include('account::admin.teams.widget')

            <div class="ibox" ng-hide="vm.editingTeams">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::admin.users.overview') }}</h5>
                </div>

                <div class="ibox-content">

                    <ul class="memberships">
                        <li ng-repeat="membership in vm.memberships" class="clearfix">

                            <div class="row">
                                <div class="col-md-6 col-xs-12 membership-info">

                                    <h4>{{ Lang::get('account::admin.members.membership') }}</h4>

                                    <img ng-src="@{{ membership.member.images[0].path }}">

                                    <div>@{{ membership.member.firstname + ' ' + membership.member.lastname }}</div>
                                    <div><a>@{{ membership.member.email }}</a></div>
                                    <div>
                                        <i ng-show="membership.member.id == {{$account->owner->id}}"
                                           class="fa fa-key owner"
                                           title="{{ Lang::get('account::admin.members.owner') }}"></i>&nbsp;{{ Lang::get('account::admin.members.owner') }}
                                    </div>

                                    <div class="clearfix"></div>

                                    @if($account->owner->id == $user->id)
                                        <p>
                                            <a class="btn btn-danger btn-lg"
                                               ng-really="vm.revokeMembership(membership)"><i
                                                    class="fa fa-trash"></i></a>
                                        </p>
                                    @endif

                                </div>

                                <div class="col-md-6 col-xs-12">

                                    <h4>{{ Lang::get('account::admin.team.teams') }}
                                        <button class="btn btn-info pull-right" ng-click="vm.startTeamEditor()">
                                            <i class="fa fa-pencil"></i></button>
                                    </h4>

                                    <ul class="nav teams">

                                        <li ng-repeat="team in vm.teams">
                                            <input type="checkbox"
                                                   id="team@{{team.id}}forMembership@{{ membership.id }}"
                                                   class="filled-in" ng-model="membership.teams[team.id].selected"
                                                   ng-change="vm.toggleTeamMembership(team, membership)">
                                            <label
                                                for="team@{{team.id}}forMembership@{{membership.id}}">@{{ team.translations[vm.options.locale].name }}</label>
                                        </li>

                                    </ul>

                                </div>

                            </div>
                        </li>
                    </ul>

                </div>

            </div>

        </div>


    </div>

</div>

