<?php

use Modules\Account\Account;
use Modules\Module\Module;
use Modules\System\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $amounts = [
        //this is the amount of resources that will be created in this run.
        'shopTable'      => 10,
        'blogTable'      => 10,
        'portfolioTable' => 10,
        'pagesTable'     => 3
    ];

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

    protected function seed($prefix)
    {
        $table = ucfirst($prefix) . 'Seeder';

        if (class_exists($table)) {

            if (isset($this->amounts[$prefix])) {
                $this->call($table, $this->amounts[$prefix]);
            } else {
                $this->call($table);
            }
        }

        $accounts = Account::all();
        $modules = Module::all();

        foreach ($accounts as $account) {
            $account->modules()->sync($modules->lists('id')->toArray());
        }
    }
}
