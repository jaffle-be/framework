<?php namespace Test\System\Pushable;

use Modules\System\Pushable\BelongsToManyPushable;
use Test\TestCase;

class BelongsToManyPushableTest extends TestCase
{

    public function testGettingPushableEventType()
    {
        $instance = new BelongsToManyPushable(['some' => 'data'], 'some relation');
        $this->assertSame('some relation', $instance->getPushableEventType());
    }

    public function testGettingPushableData()
    {
        $instance = new BelongsToManyPushable(['some' => 'data'], 'some relation');
        $this->assertSame(['some' => 'data'], $instance->getPushableData());
    }

}