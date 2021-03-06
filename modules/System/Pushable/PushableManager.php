<?php

namespace Modules\System\Pushable;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class PushableManager
 * @package Modules\System\Pushable
 */
class PushableManager
{
    protected $events;

    protected $supporting = ['created', 'deleted', 'updated', 'attached', 'detached'];

    /**
     * @param Dispatcher $events
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        if (! $this->supported($method)) {
            return;
        }

        $model = $arguments[0];

        if ($model instanceof Pushable) {
            if (in_array($method, ['attached', 'detached'])) {

                //when using attached or detached, the payload will always be an array of elements.
                //so we send all those models
                $model = $this->belongsToManyPushable($arguments);
            }

            $this->events->fire(new PushableEvent($model, $method));
        }
    }

    /**
     * @param $method
     * @return bool
     */
    protected function supported($method)
    {
        return in_array($method, $this->supporting);
    }

    /**
     * need to mock an object for many to many relation.
     * the $model passed is simply the pivot data in array form.
     *
     *
     * $model
     * @param $payload
     * @return BelongsToManyPushable
     */
    public function belongsToManyPushable($payload)
    {
        $relation = preg_replace('/eloquent\..+?: /', '', $this->events->firing());

        return new BelongsToManyPushable($payload, $relation);
    }
}
