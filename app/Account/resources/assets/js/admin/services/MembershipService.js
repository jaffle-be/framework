angular.module('account')
    .factory('MembershipService', function (Membership, MembershipInvitation, Team, $http, $timeout) {
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
            },
            teams: function(success)
            {
                Team.list({}, success);
            },
            toggleTeamMembership: function(team, membership, success)
            {
                return $http.post('/api/admin/account/team/' + team.id + '/toggle-membership', {
                    membership: membership.id,
                    status: membership.teams[team.id].selected
                }).then(success);
            },
            createNewTeam: function(name, locale, success){
                var team = new Team();
                team.translations = {};
                team.translations[locale]= {name:name};

                return team.$save().then(success);
            },
            deleteTeam: function(team, success)
            {
                return team.$delete().then(success);
            },
            updateTeam: function(team, success){
                if(this.timeout)
                {
                    $timeout.cancel(this.timeout);
                }

                this.timeout = $timeout(function(){
                    team.$update().then(success);
                }, 400);

            }
        };
    });