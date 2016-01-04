<?php namespace Test\System\Uri;

use Mockery as m;
use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\Translatable;
use Modules\System\Uri\CleanupPrepping;
use Test\TestCase;

class CleanupPreppingTranslatableMock{

    use Translatable;

    public $translations;

    public function translations()
    {
        return $this->translations;
    }
}

class CleanupPreppingTest extends TestCase
{

    public function testItDoesntFireForNonTranslationModels()
    {
        $model = m::mock('stdClass');
        $model->shouldNotReceive('translations');
        $model->shouldNotReceive('load');

        $prepper = new CleanupPrepping();
        $prepper->handle($model);
    }

    public function testItDoesntFireForTranslationsModelsThatArentSluggable()
    {
        $related = m::mock('stdClass');

        $translations = m::mock('some_translations');
        $translations->shouldReceive('getRelated')->once()->andReturn($related);

        $translatable = new CleanupPreppingTranslatableMock();
        $translatable->translations = $translations;

        $prepper = new CleanupPrepping();
        $prepper->handle($translatable);
    }


    public function testItFiresForTranslationModelsThatAreSluggable()
    {
        $related = m::mock(OwnsSlug::class);

        $translations = m::mock('some_translations');
        $translations->shouldReceive('getRelated')->once()->andReturn($related);

        $translatable = m::mock(CleanupPreppingTranslatableMock::class);
        $translatable->shouldReceive('load')->with(['translations','translations.slug'])->once();
        $translatable->shouldReceive('translations')->once()->andReturn($translations);

        $prepper = new CleanupPrepping();
        $prepper->handle($translatable);
    }

}
