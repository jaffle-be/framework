<?php namespace Test\System\Translatable;

use Modules\System\Translatable\SimpleTranslationCollection;
use Test\TestCase;
use Mockery as m;

class SimpleTranslationCollectionTest extends TestCase
{

    public function testToArrayMethod()
    {
        $collection = new SimpleTranslationCollection([
            ['locale' => 'en', 'name' => 'senior'],
            ['locale' => 'fr', 'name' => 'junior'],
        ]);

        $result = $collection->toArray();

        $this->assertSame([
            'en' => [
                'locale' => 'en', 'name' => 'senior',
            ],
            'fr' => [
                'locale' => 'fr', 'name' => 'junior',
            ]
        ], $result);
    }

    public function testToJson()
    {
        $collection = new SimpleTranslationCollection([
            ['locale' => 'en', 'name' => 'senior'],
            ['locale' => 'fr', 'name' => 'junior'],
        ]);

        $this->assertSame('{"0":{"locale":"en","name":"senior"},"1":{"locale":"fr","name":"junior"}}', $collection->toJson());
    }

}
