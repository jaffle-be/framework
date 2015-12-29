<?php namespace Test\System\Uri;

use Mockery as m;
use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\Translatable;
use Modules\System\Uri\CleanupPrepping;
use Test\TestCase;

class CleanupPreppingTranslatableMock{

    use Translatable;
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
        $related->shouldNotReceive('load');

        $model = m::mock(CleanupPreppingTranslatableMock::class);
        $model->shouldReceive('translations')->andReturn($related);

        $prepper = new CleanupPrepping();
        $prepper->handle($model);
    }


    public function testItFiresForTranslationModelsThatAreSluggable()
    {
        $related = m::mock(OwnsSlug::class);
        $related->shouldReceive('load')->with(['translations', 'translations.slug']);

        $model = m::mock(CleanupPreppingTranslatableMock::class);
        $model->shouldReceive('translations')->andReturn($related);

        $prepper = new CleanupPrepping();
        $prepper->handle($model);
    }

}
