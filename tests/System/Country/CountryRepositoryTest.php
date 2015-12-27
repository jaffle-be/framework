<?php

namespace Test\System\Country;

use Illuminate\Database\Connection;
use Modules\System\Country\Country;
use Modules\System\Country\CountryRepository;
use Modules\System\Country\CountryTranslation;
use Test\TestCase;

class CountryRepositoryTest extends TestCase
{
    public function testItCanFindCountryByIsoCode2()
    {
        /* @var $db Connection */
        $db = app('db');

        $country_id = $this->seedCountry($db);

        $repo = $this->getRepo();

        $country = $repo->findByIsoCode2('xx');

        $this->assertSame($country->id, $country_id);

        $this->cleanCountries($db);
    }

    public function testItReturnsNullWhenNoCountryFound()
    {
        $repo = $this->getRepo();

        $this->assertNull($repo->findByIsoCode2('xx'));
    }

    public function testItCanReturnAnIsoCode2BasedArray()
    {
        $repo = $this->getRepo();

        $db = app('db');

        $amount = $db->table('country')->count();

        $samples = Country::with('translations')->take(2)->get();

        $result = $repo->select()->toArray();

        foreach ($samples as $sample) {
            $this->assertArraySubset([$sample->iso_code_2 => $sample->name], $result);
        }

        $this->assertCount($amount, $result);
    }

    /**
     * @param $db
     */
    protected function cleanCountries($db)
    {
        $db->table('country')->where([
            'iso_code_2' => 'xx',
        ])->delete();
    }

    /**
     * @param $db
     *
     * @return mixed
     */
    protected function seedCountry($db)
    {
        $country_id = $db->table('country')->insertGetId([
            'iso_code_2' => 'xx',
            'iso_code_3' => 'xxx',
        ]);

        return $country_id;
    }

    /**
     * @return CountryRepository
     */
    protected function getRepo()
    {
        $repo = new CountryRepository(app(), new Country(), new CountryTranslation());

        return $repo;
    }
}
