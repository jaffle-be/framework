angular.module('account')
    .controller('MembershipsController', function (MembershipService, Team) {

        this.invitations = [];
        this.invitationErrors = [];
        this.memberships = [];
        this.editingTeams = false;
        this.teamSummernote = {
            toolbar: [
                ['edit',['undo','redo']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
            ]
        }

        var me = this;

        this.load = function () {
            MembershipService.list(function (memberships) {
                me.memberships = memberships
            });

            MembershipService.invitations(function (invitations) {
                me.invitations = invitations;
            });

            MembershipService.teams(function(teams){
                me.teams = teams;
            });
        };

        this.sendInvitation = function () {
            var email = invitationForm.email.value;
            var success = function (invitation) {
                me.invitations.push(invitation);
                invitationForm.email.value = '';
            };

            var error = function (response) {
                me.invitationErrors = response.data;
            };

            MembershipService.invite(email, success, error);
        };

        this.revokeInvitation = function (invitation) {
            MembershipService.revokeInvitation(invitation, function (response) {
                if (!response.id)
                {
                    _.remove(me.invitations, function (item) {
                        return item.id == invitation.id;
                    });
                }
            });
        };

        this.revokeMembership = function (membership) {
            MembershipService.revokeMembership(membership, function (response) {
                if(!response.id)
                {
                    _.remove(me.memberships, function (item) {
                        return item.id == membership.id;
                    });
                }
            });
        };

        this.toggleTeamMembership = function(team, membership){
            MembershipService.toggleTeamMembership(team, membership, function(){

            });
        };


        this.createNewTeam = function()
        {
            MembershipService.createNewTeam(this.newTeamName, this.options.locale, function(team)
            {
                me.teams.push(team);
                team.selected = false;
                _.each(me.memberships, function(membership)
                {
                    membership.teams[team.id] = team;
                });

            });
        };

        this.deleteTeam = function(team)
        {
            MembershipService.deleteTeam(team, function()
            {
                _.remove(me.teams, function(item){
                    return item.id == team.id;
                });

                _.each(me.memberships, function(membership){

                    _.remove(membership.teams, function(item){
                        return item.id == team.id;
                    });

                });
            });
        };

        this.updateTeam = function(team){
            MembershipService.updateTeam(team, function()
            {

            });
        };

        this.startTeamEditor = function()
        {
            this.editingTeams = true;
        }

        this.closeTeamEditor = function()
        {
            this.editingTeams = false;
        }

        this.load();

    });