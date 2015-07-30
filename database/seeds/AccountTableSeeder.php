<?php

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Account\Membership;
use App\Account\MembershipInvitation;
use App\Contact\Address;
use App\Users\User;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Jaffle\Tools\Seeder;

class AccountTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $account = Account::create([
            'user_id' => 1,
            'alias' => 'digiredo',
            'domain' => 'digiredo.local',
        ]);

        //we always! need a membership for the owner
        $info = new AccountContactInformation([
            'email' => 'thomas@jaffle.be',
            'phone' => '0473/506720',
            'website' => 'http://jaffle.be',
            'vat' => '0538.819.360',
            'hours' => json_encode([
                'some random hours',
                'lol',
                'lol',
                'lol'
            ]),
            'nl' => [
                'form_description' => $this->nl->text(),
                'widget_title' => $this->nl->words(13, true),
                'widget_content' => $this->nl->text()
            ],
            'en' => [
                'form_description' => $this->en->text(),
                'widget_title' => $this->en->words(13, true),
                'widget_content' => $this->en->text()
            ],
            'fr' => [
                'form_description' => $this->fr->text(),
                'widget_title' => $this->fr->words(13, true),
                'widget_content' => $this->fr->text()
            ],
            'de' => [
                'form_description' => $this->de->text(),
                'widget_title' => $this->de->words(13, true),
                'widget_content' => $this->de->text()
            ]
        ]);

        $account->contactInformation()->save($info);

        $info->address()->save(new Address([
            'latitude' => '50.8909351',
            'longitude' => '3.4132522',
            'firstname' => '',
            'lastname' => '',
            'street' => 'Stuifkouter',
            'box' => '64',
            'postcode' => '8790',
            'city' => 'Waregem',

            'country_id' => rand(1,4)
        ]));


        foreach(User::all() as $user)
        {
            Membership::create([
                'user_id' => $user->id,
                'account_id' => $account->id
            ]);
        }

        for($i = 0; $i < 5; $i++)
        {
            $account->membershipInvitations()->create([
                'email' => $this->faker->email
            ]);
        }

    }

}