<?php

use App\Account\Membership;
use App\System\Seeder;
use App\Users\User;

class MembershipSeeder extends Seeder
{

    public function run()
    {
        foreach (User::all() as $user) {
            $membership = new Membership();
            $membership->user_id = $user->id;
            $membership->account_id = 1;
            $membership->role_id = 1;
            $membership->is_owner = $user->id == 1 ? 1 : 0;
            $membership->save();
        }
    }


}