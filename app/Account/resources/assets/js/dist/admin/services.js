angular.module('account')
    .factory('MembershipService', function (Membership, MembershipInvitation) {
        return {
            list: function(success)
            {
                Membership.list({}, success);
            },
            invitations: function(success)
            {
                MembershipInvitation.list({}, success);
            },
            invite: function(email, success, error)
            {
                var invitation = new MembershipInvitation();
                invitation.email = email;
                invitation.$save(success, error);
            },
            revokeInvitation: function(invitation, success)
            {
                invitation.$delete({}, success);
            },
            revokeMembership: function(membership, success)
            {
                membership.$delete({}, success);
            }

        }
    });