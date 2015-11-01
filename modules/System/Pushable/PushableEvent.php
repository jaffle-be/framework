<?php namespace Modules\System\Pushable;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PushableEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

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
            $this->data->getPushableChannel()
        ];
    }

    public function broadcastAs()
    {
        if ($name = $this->data->getPushableEventType()) {
            return $name . '.' . $this->event;
        }

        return $this->cleanedType() . '.' . $this->event;
    }

    public function broadcastWith()
    {
        return $this->data->getPushableData();
    }

    /**
     * @return array|mixed|string
     */
    protected function cleanedType()
    {
        $type = explode('\\', $this->type);

        $type = array_map(function ($item) {
            return snake_case($item);
        }, $type);

        $type = implode('.', $type);

        $type = preg_replace('/modules\.(.+?)\./', '', $type, 1);

        return $type;
    }

}