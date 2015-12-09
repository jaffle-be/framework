<?php namespace Test\System\Pushable;

use Illuminate\Contracts\Events\Dispatcher;
use Modules\System\Pushable\BelongsToManyPushable;
use Modules\System\Pushable\Pushable;
use Modules\System\Pushable\PushableEvent;
use Modules\System\Pushable\PushableManager;
use Test\TestCase;
use Mockery as m;

class DummyPushableModel implements Pushable
{

    public function getPushableChannel()
    {
        return 'event_channel';
    }

    public function getPushableEventType()
    {
        return 'event_type';
    }

    public function getPushableData()
    {
        return ['some' => 'data'];
    }

}

class PushableManagerTest extends TestCase
{

    public function testUnsupportedEventWillSimplyReturnWithoutFiringEvents()
    {
        $events = m::mock(\Illuminate\Events\Dispatcher::class);
        $events->shouldNotReceive('fire');

        $manager = new PushableManager($events);
        $manager->someUnsupportedEvent('some', 'arguments');
    }

    public function testAnEventDoesNotGetFiredWhenTheModelIsNoPushable()
    {
        $events = m::mock(\Illuminate\Events\Dispatcher::class);
        $events->shouldNotReceive('fire');

        $manager = new PushableManager($events);
        $manager->created('not a pushable instance');
    }

    public function testAnEventDoesGetFiredWhenTheModelIsAPushable()
    {
        $dispatcher = m::spy(Dispatcher::class);
        $dispatcher->shouldReceive('fire')->times(5);

        $manager = new PushableManager($dispatcher);
        $manager->created(new DummyPushableModel());
        $manager->updated(new DummyPushableModel());
        $manager->deleted(new DummyPushableModel());
        $manager->attached(new DummyPushableModel());
        $manager->detached(new DummyPushableModel());
    }

    public function testBuildingBelongsToManyPushable()
    {
        $dispatcher = m::mock(Dispatcher::class);
        $dispatcher->shouldReceive('firing')->andReturn('some event type');

        $manager = new PushableManager($dispatcher);
        $instance = $manager->belongsToManyPushable(['payload']);

        $this->assertInstanceOf(BelongsToManyPushable::class, $instance);
        $this->assertSame(['payload'], $instance->getPushableData());
        $this->assertSame('some event type', $instance->getPushableEventType());
    }

}