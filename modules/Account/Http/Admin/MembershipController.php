<?php

namespace Modules\Account\Http\Admin;

use Modules\Account\AccountManager;
use Modules\Account\Jobs\Membership\RevokeMembership;
use Modules\Account\Membership;
use Modules\System\Http\AdminController;

/**
 * Class MembershipController
 * @package Modules\Account\Http\Admin
 */
class MembershipController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page()
    {
        return view('account::admin.members.overview');
    }

    /**
     * this is the method to update some membership information, currently it has nothing
     * but it should be able to adjust the membership roles in the future.
     */
    public function update()
    {
        //        $this->dispatch();
    }

    /**
     * @param AccountManager $manager
     * @return
     */
    public function index(AccountManager $manager)
    {
        $account = $manager->account();

        $account->load(['memberships', 'memberships.member', 'memberships.member.images', 'memberships.teams', 'teams', 'teams.translations']);

        $teams = $account->teams;

        foreach ($teams as $team) {
            $team->selected = false;
        }

        $teams = $teams->keyBy('id');

        foreach ($account->memberships as $membership) {
            $membershipTeams = clone $teams;

            foreach ($membership->teams as $team) {
                $team->selected = true;

                $membershipTeams->put($team->id, $team);
            }

            $membership->setRelation('teams', $membershipTeams);
        }

        return $account->memberships;
    }

    /**
     * @param Membership $membership
     * @return Membership
     */
    public function destroy(Membership $membership)
    {
        /*
         * cannot destroy a final membership or the owner of an account
         */
        if ($this->dispatch(new RevokeMembership($membership))
        ) {
            $membership->id = false;
        }

        return $membership;
    }
}
