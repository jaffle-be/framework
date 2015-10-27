<?php

namespace Modules\Contact\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Contact\Address;
use Modules\System\Country\CountryRepository;

class UpdateAddress extends Job implements SelfHandling{

    /**
     * @var Address
     */
    protected $address;
    /**
     * @var array
     */
    protected $input;

    public function __construct(Address $address, array $input)
    {

        $this->address = $address;
        $this->input = $input;
    }

    public function handle(CountryRepository $countries)
    {
        //the interface changes the iso_code_2 when we update a country
        //so if we check if the id in database of that iso_code is the same as the id in the input array
        //we know that the country didn't change.
        //if they are different, the country did change.
        $newCountry = $this->input['country'];

        $newCountry = $countries->findByIsoCode2($newCountry['iso_code_2']);

        if($newCountry)
        {
            $this->address->fill(array_except($this->input, ['country']));

            if($newCountry->id != $this->input['country']['id'])
            {
                $this->address->country()->associate($newCountry);
            }

            return $this->address->save();
        }

        return false;
    }

}