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
        Model::unguard();

        $seeders = ['countryTable', 'accountTable', 'contactTable', 'usersTable', 'menuTable', 'tagTable', 'client', 'membership', 'team', 'profile', 'blogTable', 'portfolioTable'];

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
