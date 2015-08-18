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
        if(env('APP_ENV') == 'production')
        {
            $account = Account::create([
                'alias'   => 'digiredo',
                'domain'  => 'digiredo.be',
            ]);
        }
        else if(env('APP_ENV') == 'develop')
        {
            $account = Account::create([
                'alias'   => 'digiredo',
                'domain'  => 'dev.digiredo.be',
            ]);
        }
        else{
            $account = Account::create([
                'alias'   => 'digiredo',
                'domain'  => 'digiredo.local',
            ]);
        }

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
        ]);

        $account->contactInformation()->save($info);

        $address = new Address([
            'latitude' => '50.8909351',
            'longitude' => '3.4132522',
            'firstname' => '',
            'lastname' => '',
            'street' => 'Stuifkouter',
            'box' => '64',
            'postcode' => '8790',
            'city' => 'Waregem',
        ]);

        $address->country_id = 21;

        $info->address()->save($address);
    }

}