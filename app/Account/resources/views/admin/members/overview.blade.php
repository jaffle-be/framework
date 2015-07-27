<div class="wrapper-content" ng-controller="MembershipsController as vm">

    <div class="row">

        <div class="col-md-6">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::users.send-invite') }}</h5>
                </div>

                <div class="ibox-content">

                    <div class="form-group">

                        <ul>
                            <li ng-repeat="invitation in vm.invitations">
                                <a class="pull-right btn btn-danger btn-sm" ng-click="vm.revokeInvitation(invitation)">{{ Lang::get('account::users.remove') }}</a>
                                @{{ invitation.email }} <br>
                                {{ Lang::get('account::users.since') }}: @{{ invitation.created_at | fromNow }}
                            </li>
                        </ul>

                        <br>

                        <form name="invitationForm">
                            <input autocomplete="off" class="form-control" type="text" name="email" id="email" placeholder="{{ Lang::get('account::users.email') }}"/>

                        </form>

                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-lg" ng-click="vm.sendInvitation()">{{ Lang::get('account::users.send') }}</button>
                    </div>

                    <input-errors errors="vm.invitationErrors"></input-errors>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::users.overview') }}</h5>
                </div>

                <div class="ibox-content">

                    <ul>
                        <li ng-repeat="membership in vm.memberships">
                            @if($account->owner->id == $user->id)
                            <a class="pull-right btn btn-sm btn-danger">{{ Lang::get('account::users.remove') }}</a>
                            @endif

                            @{{ membership.member.firstname + ' ' + membership.member.lastname }}<br>
                            <a>@{{ membership.member.email }}</a>

                        </li>
                    </ul>

                </div>

            </div>

        </div>


    </div>

</div>

