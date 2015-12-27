<?php

namespace Modules\System\Pushable;

/**
 * Class BelongsToManyPushable
 * @package Modules\System\Pushable
 */
class BelongsToManyPushable implements Pushable
{
    protected $data;

    protected $relation;

    use CanPush;

    /**
     * BelongsToManyPushable constructor.
     * @param array $data
     * @param $relation
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

    /**
     * @return array
     */
    public function getPushableData()
    {
        return $this->data;
    }
}
