<?php namespace Modules\System\Pushable;

use Illuminate\Events\Dispatcher;

class PushableManager
{

    protected $events;

    protected $supporting = ['created', 'deleted', 'updated', 'attached', 'detached'];

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    public function __call($method, $arguments)
    {
        if (!$this->supported($method)) {
            return;
        }

        $model = $arguments[0];

        if (in_array($method, ['attached', 'detached'])) {

            //when using attached or detached, the payload will always be an array of elements.
            //so we send all those models
            $model = $this->dataAsPushable($arguments);
        }

        if ($model instanceof Pushable) {
            $this->events->fire(new PushableEvent($model, $method));
        }
    }

    protected function supported($method)
    {
        return in_array($method, $this->supporting);
    }

    /**
     * need to mock an object for many to many relation.
     * the $model passed is simply the pivot data in array form.
     *
     * @param $model
     *
     * @return BelongsToManyPushable
     */
    protected function dataAsPushable($payload)
    {

        $relation = preg_replace('/eloquent\..+?: /', '', $this->events->firing());

        return new BelongsToManyPushable($payload, $relation);
    }

}