<?php

namespace Modules\Contact;

trait OwnsAddress
{
    public function address()
    {
        return $this->morphOne('Modules\Contact\Address', 'owner');
    }
}
