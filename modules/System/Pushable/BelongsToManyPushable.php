<?php namespace Modules\System\Pushable;

class BelongsToManyPushable implements Pushable
{

    public $data;

    protected $relation;

    use CanPush;

    /**
     * BelongsToManyPushable constructor.
     */
    public function __construct(array $data, $relation)
    {
        $this->data = $data;
        $this->relation = $relation;
    }

    public function getPushableEventType()
    {
        return $this->relation;
    }

    public function getPushableData()
    {
        return $this->data;
    }

}