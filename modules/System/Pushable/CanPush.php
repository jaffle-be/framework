<?php

namespace Modules\System\Pushable;

use Modules\System\Scopes\ModelAccountResource;

/**
 * Class CanPush
 * @package Modules\System\Pushable
 */
trait CanPush
{
    /**
     * @return string
     */
    public function getPushableChannel()
    {
        if (property_exists(get_class($this), 'pushableChannel')) {
            return $this->pushableChannel;
        }

        if ($this instanceof ModelAccountResource) {
            return pusher_account_channel();
        }

        return pusher_system_channel();
    }

    /**
     * @return mixed
     */
    public function getPushableEventType()
    {
        if (property_exists(get_class($this), 'pushableEventName')) {
            return $this->pushableEventName;
        }

        $type = explode('\\', get_class($this));

        $type = array_map(function ($item) {
            return snake_case($item);
        }, $type);

        $type = implode('.', $type);

        //strip of the modules.{any module name}. part of the string
        return preg_replace('/modules\.(.+?)\./', '', $type, 1);
    }

    public function getPushableData()
    {
        return $this->toArray();
    }
}
