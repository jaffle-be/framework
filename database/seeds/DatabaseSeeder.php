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

//        $seeders = ['users', 'blog', 'tags'];
        $seeders = ['tag'];

        foreach($seeders as $seeds)
        {
            $this->seed($seeds);
        }
    }

    protected function seed($table)
    {
        $table = ucfirst($table) . 'TableSeeder';

        if(class_exists($table))
        {
            $this->call($table);
        }
    }
}
