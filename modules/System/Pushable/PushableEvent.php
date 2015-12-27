<?php

namespace Modules\System\Pushable;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class PushableEvent
 * @package Modules\System\Pushable
 */
class PushableEvent extends Event implements ShouldBroadcast
{
    public $data;

    protected $event;

    protected $type;

    /**
     * @param Pushable $pushable
     * @param $event
     */
    public function __construct(Pushable $pushable, $event)
    {
        $this->data = $pushable;
        $this->type = get_class($pushable);
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     *
     */
    public function broadcastOn()
    {
        return [
            $this->data->getPushableChannel(),
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return $this->data->getPushableEventType().'.'.$this->event;
    }

    /**
     * @return mixed
     */
    public function broadcastWith()
    {
        return $this->data->getPushableData();
    }
}
