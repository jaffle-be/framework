<?php namespace Test\System\Scopes;

use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Modules\System\Locale;
use Modules\System\Scopes\LocalisedResourceCollection;
use Modules\System\Scopes\ModelLocaleSpecificResource;
use Test\TestCase;

class DummyLocalisedResource
{

    use ModelLocaleSpecificResource;

    public $id;

    public $locale_id;

    protected $attributes;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function toArray()
    {
        return [
            'id'        => $this->id,
            'locale_id' => $this->locale_id,
        ];
    }
}

class LocalisedResourceCollectionTest extends TestCase
{

    public function testToArray()
    {
        $collection = new LocalisedResourceCollection([
            new DummyLocalisedResource([
                'id'        => 1000,
                'locale_id' => 1
            ]),

            new DummyLocalisedResource([
                'id'        => 2000,
                'locale_id' => 1
            ]),

            new DummyLocalisedResource([
                'id'        => 3000,
                'locale_id' => 2
            ])
        ]);

        $result = $collection->toArray();

        $this->assertArrayHasKey('nl', $result);
        $this->assertArrayHasKey('fr', $result);
        $this->assertArrayHasKey('en', $result);

        $this->assertTrue(is_array($result['nl']));
        $this->assertTrue(is_array($result['fr']));
        $this->assertTrue(is_array($result['en']));

        $this->assertCount(2, $result['nl']);
        $this->assertCount(1, $result['fr']);
        $this->assertCount(0, $result['en']);
    }

    public function testByLocale()
    {
        $collection = new LocalisedResourceCollection([
            new DummyLocalisedResource([
                'id'        => 1000,
                'locale_id' => 1
            ]),

            new DummyLocalisedResource([
                'id'        => 2000,
                'locale_id' => 1
            ]),

            new DummyLocalisedResource([
                'id'        => 3000,
                'locale_id' => 2
            ])
        ]);

        $result = $collection->byLocale();

        //it should contain a key, even for locales that have no resources
        $this->assertArrayHasKey('nl', $result);
        $this->assertSame(2, $result['nl']->count());
        $this->assertArrayHasKey('fr', $result);
        $this->assertSame(1, $result['fr']->count());
        $this->assertArrayHasKey('en', $result);
        $this->assertSame(0, $result['en']->count());
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function setUp()
    {
        parent::setUp();

        Locale::unguard();

        $data = [
            new Locale([
                'id'   => 1,
                'slug' => 'nl',
            ]),
            new Locale([
                'id'   => 2,
                'slug' => 'fr',
            ]),
            new Locale([
                'id'   => 3,
                'slug' => 'en',
            ])
        ];

        $locales = m::mock(Locale::class);

        $locales->shouldReceive('all')->andReturn(new Collection($data));

        $this->app[Locale::class] = $locales;
    }

}