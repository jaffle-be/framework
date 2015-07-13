<?php

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Contact\Address;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Jaffle\Tools\Seeder;

class AccountTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $account = Account::create([
            'user_id' => 1,
            'alias' => 'demo',
            'domain' => 'stores.framework.local',
        ]);

        $info = new AccountContactInformation([
            'email' => 'thomas@jaffle.be',
            'phone' => $this->nl->phoneNumber,
            'website' => $this->nl->url,
            'vat' => $this->nl->randomNumber(9),
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
            'latitude' => $this->nl->latitude,
            'longitude' => $this->nl->longitude,
            'firstname' => '',
            'lastname' => '',
            'street' => $this->nl->streetName,
            'box' => $this->nl->numberBetween(0,2666),
            'postcode' => $this->nl->postcode,
            'city' => $this->nl->city,

            'country_id' => rand(1,4)
        ]));


    }

}