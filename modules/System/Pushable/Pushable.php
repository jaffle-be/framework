<?php

namespace Modules\System\Pushable;

interface Pushable
{
    public function getPushableChannel();

    public function getPushableEventType();

    public function getPushableData();
}
