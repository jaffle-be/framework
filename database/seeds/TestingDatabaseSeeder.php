<?php

use Modules\Account\Account;
use Modules\System\Seeder;

class TestingDatabaseSeeder extends Seeder
{

    public function run()
    {
        factory(Account::class)->create();
    }

}