<?php

namespace Test\System\Pushable;

use Modules\Shop\Gamma\BrandSelection;
use Modules\System\Pushable\CanPush;
use Modules\System\Scopes\ModelAccountResource;
use Test\TestCase;

class DummyCanPush
{
    use CanPush;

    public function toArray()
    {
        return ['some' => 'data'];
    }
}

class DummyCanPushWithDefinedPushableProperties
{
    use CanPush;

    protected $pushableChannel = 'defined channel';

    protected $pushableEventName = 'defined event name';
}

class DummyCanPushAccountResource
{
    use CanPush, ModelAccountResource;
}

class CanPushTest extends TestCase
{
    public function testGettingPushableChannelWhenChannelIsDefined()
    {
        $instance = new DummyCanPushWithDefinedPushableProperties();
        $this->assertSame('defined channel', $instance->getPushableChannel());
    }

    public function testReturnsAccountChannelWhenDealingWithAnAccountResource()
    {
        $instance = new DummyCanPushAccountResource();
        $this->assertSame(pusher_account_channel(), $instance->getPushableChannel());
    }

    public function testReturnsSystemChannelByDefault()
    {
        $instance = new DummyCanPush();
        $this->assertSame(pusher_system_channel(), $instance->getPushableChannel());
    }

    public function testGettingPushableEventTypeUsesDefinedName()
    {
        $instance = new DummyCanPushWithDefinedPushableProperties();
        $this->assertSame('defined event name', $instance->getPushableEventType());
    }

    public function testGeneratedEventNameIsReturnedWhenNoEventNameIsDefined()
    {
        $instance = new DummyCanPush();
        $this->assertSame('test.system.pushable.dummy_can_push', $instance->getPushableEventType());

        $instance = new BrandSelection();
        $this->assertSame('gamma.brand_selection', $instance->getPushableEventType());
    }

    public function testGettingPushableData()
    {
        $instance = new DummyCanPush();
        $this->assertSame(['some' => 'data'], $instance->getPushableData());
    }
}
