<?php

namespace Modules\System;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MySoftDeletes
 * @package Modules\System
 */
trait MySoftDeletes
{
    use SoftDeletes;

    /**
     * @return bool
     */
    public function beingFullyDeleted()
    {
        return $this->forceDeleting;
    }
}
