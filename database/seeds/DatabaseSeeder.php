<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = ['countryTable', 'accountTable', 'menuTable', 'usersTable', 'tagTable', 'contactTable', 'client', 'membership', 'team', 'profile', 'shopTable', 'blogTable', 'portfolioTable'];

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
    }
}
