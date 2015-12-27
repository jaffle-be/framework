<?php

namespace Modules\System\Country;

use Illuminate\Foundation\Application;

class CountryRepository
{
    protected $country;

    public function __construct(Application $application, Country $country, CountryTranslation $translation)
    {
        $this->application = $application;
        $this->country = $country;
        $this->translation = $translation;
    }

    public function select()
    {
        $country = $this->country->getTable();
        $trans = $this->translation->getTable();

        return $this->country
            ->join($trans, $country.'.id', '=', $trans.'.country_id')
            ->where($trans.'.locale', $this->application->getLocale())
            ->orderBy($trans.'.name', 'asc')
            ->lists('name', 'iso_code_2');
    }

    public function findByIsoCode2($iso_code_2)
    {
        return $this->country->where('iso_code_2', $iso_code_2)
            ->first();
    }
}
