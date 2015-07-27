angular.module('account')
    .controller('AccountContactController', function ($scope, $state, AccountContactInformation, $timeout, InputTranslationHandler) {
        var me = this;

        this.timer = false;

        this.load = function () {
            AccountContactInformation.load(function (response) {
                me.info = response;
            });
        };

        this.save = function () {

            if(this.timer)
            {
                $timeout.cancel(this.timer);
            }

            this.timer = $timeout(function () {

                if (!me.info.id)
                {
                    me.info.$save(function () {
                        $scope.errors = [];
                    }, function(response){
                        $scope.errors = response.data;
                    });
                }
                else
                {
                    me.info.translations = InputTranslationHandler(me.options.locales, me.info.translations);

                    me.info.$update(function () {
                        $scope.errors = [];
                    }, function(response){
                        $scope.errors = response.data;
                    });
                }

            }, 400)
        };

        this.load();
    });
angular.module('account')
    .controller('MembershipsController', function (MembershipService) {

        this.invitations = [];
        this.invitationErrors = [];
        this.memberships = [];

        var me = this;

        this.load = function()
        {
            MembershipService.list(function(memberships)
            {
                me.memberships = memberships
            });

            MembershipService.invitations(function(invitations){
                me.invitations = invitations;
            });
        };

        this.sendInvitation = function()
        {
            var email = invitationForm.email.value;
            var success = function(invitation)
            {
                me.invitations.push(invitation);
                invitationForm.email.value = '';
            };

            var error = function(response)
            {
                me.invitationErrors = response.data;
            };

            MembershipService.invite(email, success, error);
        };

        this.revokeInvitation = function(invitation)
        {
            MembershipService.revokeInvitation(invitation, function(response)
            {
                if(response.status == 'ok')
                {
                    _.remove(me.invitations, function(item)
                    {
                        return item.id == invitation.id;
                    });
                }
            });
        };

        this.revokeMembership = function(membership)
        {
            MembershipService.revokeMembership(membership, function()
            {

            });
        };

        this.load();

    });