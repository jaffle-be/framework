<?php

namespace Modules\System\Pushable;

/**
 * Interface Pushable
 * @package Modules\System\Pushable
 */
interface Pushable
{
    public function getPushableChannel();

    public function getPushableEventType();

    public function getPushableData();
}
