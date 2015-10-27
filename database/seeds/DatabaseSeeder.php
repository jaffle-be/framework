<?php

use Illuminate\Database\Seeder;
use Modules\Account\Account;
use Modules\Module\Module;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = ['countryTable', 'accountTable', 'menuTable', 'usersTable', 'tagTable', 'contactTable', 'client', 'membership', 'team', 'profile', 'shopTable', 'blogTable', 'portfolioTable', 'pagesTable'];

        foreach ($seeders as $seeds) {
            $this->seed($seeds);
        }
    }

    protected function seed($table)
    {
        $table = ucfirst($table) . 'Seeder';

        if (class_exists($table)) {
            $this->call($table);
        }

        $accounts  = Account::all();
        $modules = Module::all();

        foreach($accounts as $account)
        {
            $account->modules()->sync($modules->lists('id')->toArray());
        }
    }
}
