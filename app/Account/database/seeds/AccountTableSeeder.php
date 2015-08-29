<?php

use App\Account\Account;
use App\Account\AccountContactInformation;
use App\Account\Role;
use App\Contact\Address;
use App\System\Seeder;
use Illuminate\Foundation\Bus\DispatchesCommands;

class AccountTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $account = $this->account('digiredo');
        $this->roles($account);
        $this->contactInformation($account);
        $this->membershipInvitations($account);

        $account = $this->account('cloudcreations');
        $this->roles($account);
        $this->contactInformation($account);
        $this->membershipInvitations($account);
    }

    protected function roles($account)
    {
        Role::create([
            'account_id' => $account->id,
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
            'account_id' => $account->id,
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
    protected function account($name)
    {
        if(env('APP_ENV') == 'production')
        {
            $account = Account::create([
                'alias'   => $name,
                'domain'  => "$name.be",
            ]);
        }
        else if(env('APP_ENV') == 'develop')
        {
            $account = Account::create([
                'alias'   => '' . $name . '',
                'domain'  => "dev.$name.be",
            ]);
        }
        else{
            $account = Account::create([
                'alias'   => $name,
                'domain'  => "$name.local",
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