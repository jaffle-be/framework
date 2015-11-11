<?php namespace Modules\System\Pushable;

use Modules\System\Scopes\ModelAccountResource;

trait CanPush
{

    public function getPushableChannel()
    {
        if(property_exists(get_class($this), 'pushableChannel'))
        {
            return $this->pushableChannel;
        }

        if($this instanceof ModelAccountResource)
        {
            return pusher_account_channel();
        }

        return pusher_system_channel();
    }

    public function getPushableEventType()
    {
        if(property_exists(get_class($this), 'pushableEventName'))
        {
            return $this->pushableEventName;
        }

        return null;
    }

    public function getPushableData()
    {
        return $this->toArray();
    }

}