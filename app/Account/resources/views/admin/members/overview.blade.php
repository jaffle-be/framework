<div class="wrapper-content" ng-controller="MembershipsController as vm">

    <div class="row">

        <div class="col-md-6 col-lg-4">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::users.send-invite') }}</h5>
                </div>

                <div class="ibox-content">

                    <div class="form-group">

                        <ul class="invitations">
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

        <div class="col-md-6 col-lg-8">

            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('account::users.overview') }}</h5>
                </div>

                <div class="ibox-content">

                    <ul class="memberships">
                        <li ng-repeat="membership in vm.memberships" class="clearfix">

                            <div class="img-wrapper">
                                <img ng-src="@{{ membership.member.images[0].path }}">
                            </div>
                            <div class="wrapper">

                                @if($account->owner->id == $user->id)
                                    <a class="pull-right btn btn-sm btn-danger" ng-click="vm.revokeMembership(membership)">{{ Lang::get('account::users.remove') }}</a>
                                @endif

                                <i ng-show="membership.member.id == {{$account->owner->id}}" class="fa fa-key owner" title="{{ Lang::get('account::members.owner') }}"></i>

                                <div>@{{ membership.member.firstname + ' ' + membership.member.lastname }}</div>
                                <a>@{{ membership.member.email }}</a>
                            </div>
                        </li>
                    </ul>

                </div>

            </div>

        </div>


    </div>

</div>

