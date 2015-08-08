<?php

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Account\Role;
use App\Contact\Address;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Jaffle\Tools\Seeder;

class AccountTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $account = $this->account();
        $this->roles();
        $this->contactInformation($account);
        $this->membershipInvitations($account);
    }

    protected function roles()
    {
        Role::create([
            'account_id' => 1,
            'nl' => [
                'name' => 'admin',
            ],
            'fr' => [
                'name' => 'admin',
            ],
            'en' => [
                'name' => 'admin',
            ],
            'de' => [
                'name' => 'admin',
            ],
        ]);

        Role::create([
            'account_id' => 1,
            'nl' => [
                'name' => 'guest',
            ],
            'fr' => [
                'name' => 'guest',
            ],
            'en' => [
                'name' => 'guest',
            ],
            'de' => [
                'name' => 'guest',
            ],
        ]);
    }

    /**
     * @param $account
     */
    protected function membershipInvitations($account)
    {
        for ($i = 0; $i < 5; $i++) {
            $account->membershipInvitations()->create([
                'email' => $this->faker->email
            ]);
        }
    }

    /**
     * @return static
     */
    protected function account()
    {
        $account = Account::create([
            'alias'   => 'digiredo',
            'domain'  => 'digiredo.local',
        ]);

        return $account;
    }

    /**
     * @param $account
     *
     * @return AccountContactInformation
     */
    protected function contactInformation($account)
    {
        $info = new AccountContactInformation([
            'email'   => 'thomas@jaffle.be',
            'phone'   => '0473/506720',
            'website' => 'http://jaffle.be',
            'vat'     => '0538.819.360',
            'hours'   => json_encode([
                'some random hours',
                'lol',
                'lol',
                'lol'
            ]),
            'nl'      => [
                'form_description' => $this->nl->text(),
                'widget_title'     => $this->nl->words(13, true),
                'widget_content'   => $this->nl->text()
            ],
            'en'      => [
                'form_description' => $this->en->text(),
                'widget_title'     => $this->en->words(13, true),
                'widget_content'   => $this->en->text()
            ],
            'fr'      => [
                'form_description' => $this->fr->text(),
                'widget_title'     => $this->fr->words(13, true),
                'widget_content'   => $this->fr->text()
            ],
            'de'      => [
                'form_description' => $this->de->text(),
                'widget_title'     => $this->de->words(13, true),
                'widget_content'   => $this->de->text()
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
    }

}