<?php

use Modules\Account\Membership;
use Modules\System\Seeder;
use Modules\Users\User;

/**
 * Class MembershipSeeder
 */
class MembershipSeeder extends Seeder
{
    public function run()
    {
        foreach ([1, 2] as $account) {
            foreach (User::all() as $user) {
                $membership = new Membership();
                $membership->user_id = $user->id;
                $membership->account_id = $account;
                $membership->role_id = 1;
                $membership->is_owner = $user->id == 1 ? 1 : 0;
                $membership->save();
            }
        }
    }
}
