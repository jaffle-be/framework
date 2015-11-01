<?php namespace Modules\System\Pushable;

use Illuminate\Events\Dispatcher;

class Manager
{
    protected $events;

    protected $supporting = ['created', 'deleted', 'updated', 'attached', 'detached'];

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    public function __call($method, $arguments)
    {
        $model = $arguments[0];

        if(!$this->supported($method))
        {
            return;
        }

        if($model instanceof Pushable)
        {
            $this->events->fire(new PushableEvent($model, $method));
        }
    }

    protected function supported($method)
    {
        return in_array($method, $this->supporting);
    }

}