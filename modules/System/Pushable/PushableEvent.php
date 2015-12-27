<?php

namespace Modules\System\Pushable;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PushableEvent extends Event implements ShouldBroadcast
{
    public $data;

    protected $event;

    protected $type;

    public function __construct(Pushable $pushable, $event)
    {
        $this->data = $pushable;
        $this->type = get_class($pushable);
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            $this->data->getPushableChannel(),
        ];
    }

    public function broadcastAs()
    {
        return $this->data->getPushableEventType().'.'.$this->event;
    }

    public function broadcastWith()
    {
        return $this->data->getPushableData();
    }
}
