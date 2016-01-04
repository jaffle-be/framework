<?php namespace Test\System\Translatable;

use Mockery as m;
use Modules\System\Translatable\TranslationCollection;
use Test\TestCase;

class TranslationCollectionTest extends TestCase
{

    public function testToArrayMethod()
    {
        $collection = new TranslationCollection([
            ['locale_id' => '1', 'name' => 'senior'],
            ['locale_id' => '3', 'name' => 'junior'],
        ]);

        $expected = [
            "nl" => [
                "locale_id" => "1",
                "name" => "senior",
            ],
            "en" => [
                "locale_id" => "3",
                "name" => "junior",
            ],
        ];

        $this->assertSame($expected, $collection->toArray());
    }

    public function testToJson()
    {
        $collection = new TranslationCollection([
            ['locale_id' => '1', 'name' => 'senior'],
            ['locale_id' => '3', 'name' => 'junior'],
        ]);

        $this->assertSame('{"0":{"locale_id":"1","name":"senior"},"1":{"locale_id":"3","name":"junior"}}', $collection->toJson());
    }

}
