<?php namespace Test\System\Uri;

use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Uri\Creator;
use Test\TestCase;
use Mockery as m;

class CreatorTest extends TestCase
{


    public function testItWorksForSluggables()
    {
        $sluggable = m::mock(OwnsSlug::class);

        $sluggable->shouldReceive('sluggify')->once();
        $sluggable->shouldReceive('save')->once();
        $creator = new Creator();
        $creator->handle($sluggable);
    }


    public function testItDoesntFireForNonSluggables()
    {
        $nonSluggable = m::mock('stdClass');
        $nonSluggable->shouldNotReceive('sluggify');
        $nonSluggable->shouldNotReceive('save');

        $creator = new Creator();
        $creator->handle($nonSluggable);
    }

}
