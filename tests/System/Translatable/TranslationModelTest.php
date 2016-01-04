<?php namespace Test\System\Translatable;

use Modules\System\Translatable\SimpleTranslationCollection;
use Modules\System\Translatable\TranslationModel;
use Test\TestCase;

class TranslationModelTest extends TestCase
{

    public function testGettingNewCollection()
    {
        $model = new TranslationModel();
        $collection = $model->newCollection([1, 2]);
        $this->assertInstanceOf(SimpleTranslationCollection::class, $collection);
        $this->assertSame(2, $collection->count());
    }

}
