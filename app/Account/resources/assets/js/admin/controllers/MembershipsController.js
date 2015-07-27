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