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

        $seeders = ['country', 'contact', 'users', 'menu', 'account', 'tag', 'blog'];

        foreach ($seeders as $seeds) {
            $this->seed($seeds);
        }
    }

    protected function seed($table)
    {
        $table = ucfirst($table) . 'TableSeeder';

        if (class_exists($table)) {
            $this->call($table);
        }
    }
}
