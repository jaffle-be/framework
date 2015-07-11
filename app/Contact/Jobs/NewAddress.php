<?php namespace App\Contact\Jobs;

use App\Contact\AddressOwner;
use App\Jobs\Job;
Use App\Contact\Address;
use App\System\Country\CountryRepository;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

class NewAddress extends Job implements SelfHandling
{
    protected $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public function handle(Address $address, CountryRepository $countries, Repository $config)
    {
        $owners = $config->get('contact.address_owners');

        $owner = $this->resolveOwner($owners, $this->input['owner_id'], $this->input['owner_type']);

        if(is_a($owner, AddressOwner::class))
        {
            //the interface changes the iso_code_2 when we update a country
            //so if we check if the id in database of that iso_code is the same as the id in the input array
            //we know that the country didn't change.
            //if they are different, the country did change.
            $newCountry = $this->input['country'];

            $newCountry = $countries->findByIsoCode2($newCountry['iso_code_2']);

            if($newCountry)
            {
                $address->fill(array_except($this->input, ['country']));

                $address->country()->associate($newCountry);

                return $owner->address()->save($address) ? $address : false;
            }
        }

        return false;
    }

    protected function resolveOwner($owners, $owner_id, $owner_type)
    {
        if(!isset($owners[$owner_type]))
        {
            throw new Exception('Invalid owner type trying to create address');
        }

        $finder = new $owners[$owner_type]();

        return $finder->findOrFail($owner_id);
    }

}