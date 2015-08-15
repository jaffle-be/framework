<?php

use App\Users\User;
use Jaffle\Tools\Seeder;

class UsersTableSeeder extends Seeder{

    public function run()
    {
        User::create([
            'email' => 'thomas.warlop@gmail.com',
            'password' => \Hash::make('thomasthomas'),
            'firstname' => 'Thomas',
            'lastname' => 'Warlop',
            'confirmed' => 1
        ]);

        $users = ['Ruud' => 'Van Der Heyden', 'Gauthier' => 'Geldhof', 'Igor' => 'Delameilleure'];


        foreach($users as $firstname => $lastname)
        {
            User::create([
                'email' => 'thomas.warlop@gmail.com',
                'password' => \Hash::make('thomasthomas'),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'confirmed' => 1
            ]);
        }
    }



}