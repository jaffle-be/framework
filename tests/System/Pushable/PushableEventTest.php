<?php namespace Test\System\Pushable;

use Modules\System\Pushable\Pushable;
use Modules\System\Pushable\PushableEvent;
use Test\TestCase;


class DataDummyPushable implements Pushable{

    public function getPushableChannel()
    {
        return 'some channel';
    }

    public function getPushableEventType()
    {
        return 'some event';
    }

    public function getPushableData()
    {
        return 'pushable data';
    }

}

class PushableEventTest extends TestCase
{

    public function testGettingTheChannelToBroadcastOn()
    {
        $event = new PushableEvent(new DataDummyPushable(), 'some name');
        $this->assertSame(['some channel'], $event->broadcastOn());
    }

    public function testGettingTheDataToBroadcastWith()
    {
        $event = new PushableEvent(new DataDummyPushable(), 'some name');
        $this->assertSame('pushable data', $event->broadcastWith());
    }

    public function testGettingTheEventToBroadcastAs()
    {
        $event = new PushableEvent(new DataDummyPushable(), 'some name');
        $this->assertSame('some event.some name', $event->broadcastAs());
    }
}