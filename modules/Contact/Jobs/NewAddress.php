<?php

namespace Modules\Contact\Jobs;

use App\Jobs\Job;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Modules\Contact\Address;
use Modules\Contact\AddressOwner;
use Modules\System\Country\CountryRepository;

/**
 * Class NewAddress
 * @package Modules\Contact\Jobs
 */
class NewAddress extends Job
{
    protected $input;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * @param Address $address
     * @param CountryRepository $countries
     * @param Repository $config
     * @return bool|Address
     * @throws Exception
     */
    public function handle(Address $address, CountryRepository $countries, Repository $config)
    {
        $owners = $config->get('contact.address_owners');

        $owner = $this->resolveOwner($owners, $this->input['owner_id'], $this->input['owner_type']);

        if (is_a($owner, AddressOwner::class)) {
            //the interface changes the iso_code_2 when we update a country
            //so if we check if the id in database of that iso_code is the same as the id in the input array
            //we know that the country didn't change.
            //if they are different, the country did change.
            $newCountry = $this->input['country'];

            $newCountry = $countries->findByIsoCode2($newCountry['iso_code_2']);

            if ($newCountry) {
                $address->fill(array_except($this->input, ['country']));

                $address->country()->associate($newCountry);

                return $owner->address()->save($address) ? $address : false;
            }
        }

        return false;
    }

    /**
     * @param $owners
     * @param $owner_id
     * @param $owner_type
     * @return mixed
     * @throws Exception
     */
    protected function resolveOwner($owners, $owner_id, $owner_type)
    {
        if (! isset($owners[$owner_type])) {
            throw new Exception('Invalid owner type trying to create address');
        }

        $finder = new $owners[$owner_type]();

        return $finder->findOrFail($owner_id);
    }
}
