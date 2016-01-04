<?php namespace Test\System\Uri;

use Mockery as m;
use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\Translatable;
use Modules\System\Uri\Cleanup;
use Test\TestCase;

class CleanupTranslatableMock{

    use Translatable;

    public $translations;
}

class CleanupTest extends TestCase
{

    public function test_it_wont_fire_for_a_resource_that_should_not_be_slugged()
    {
        $model = $this->getMock('stdClass')->expects($this->never())->method($this->anything());
        $cleanup = new Cleanup();
        $cleanup->handle($model);
    }

    public function test_it_deletes_the_slug_if_it_is_a_sluggable_model()
    {
        $related = m::mock('anything');
        $related->shouldReceive('delete')->once();

        $sluggable = m::mock(OwnsSlug::class);
        $sluggable->shouldReceive('slug')->once()->andReturn($related);

        $cleanup = new Cleanup();
        $cleanup->handle($sluggable);
    }


    public function test_it_deletes_the_slugs_for_translations_if_its_a_translatable_model()
    {
        //we need the translation model to be sluggable
        $related = m::mock(OwnsSlug::class);
        $relation = m::mock('translation_relation');
        $relation->shouldReceive('getRelated')->once()->andReturn($related);

        $model = m::mock(CleanupTranslatableMock::class);
        $model->shouldReceive('translations')->once()->andReturn($relation);

        //we'll mock the actual translations with an array having 2 translations

        //so we expect 2 different slugs to be deleted
        $slugOne = m::mock('slug_one');
        $slugOne->shouldReceive('delete')->once();
        $slugTwo = m::mock('slug_two');
        $slugTwo->shouldReceive('delete')->once();

        //one for each translation
        $translationOne = m::mock('sluggable_translation_one');
        $translationOne->shouldReceive('slug')->once()->andReturn($slugOne);
        $translationTwo = m::mock('sluggable_translation_two');
        $translationTwo->shouldReceive('slug')->once()->andReturn($slugTwo);

        //set both the translations on the model we're cleaning up
        $model->translations = [
            $translationOne,
            $translationTwo
        ];

        //trigger
        $cleanup = new Cleanup();
        $cleanup->handle($model);
    }

}
