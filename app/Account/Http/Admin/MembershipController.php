<?php namespace App\Account\Http\Admin;

use App\Account\AccountManager;
use App\Account\Jobs\Membership\RevokeMembership;
use App\Account\Membership;
use App\Http\Controllers\AdminController;
use Illuminate\Contracts\Auth\Guard;

class MembershipController extends AdminController
{

    public function page()
    {
        return view('account::admin.members.overview');
    }

    /**
     * this is the method to update some membership information, currently it has nothing
     * but it should be able to adjust the membership roles in the future
     */
    public function update()
    {
//        $this->dispatch();
    }

    public function index(AccountManager $manager)
    {
        $account = $manager->account();

        $account->load(['memberships', 'memberships.member', 'memberships.member.images']);

        return $account->memberships;
    }

    public function destroy(Membership $membership)
    {
        /**
         * cannot destroy a final membership or the owner of an account
         */
        if($this->dispatchFromArray(RevokeMembership::class, [
            'membership' => $membership
        ]))
        {
            $membership->id = false;
        }

        return $membership;
    }

}