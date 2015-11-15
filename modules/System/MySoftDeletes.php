<?php namespace Modules\System;

use Illuminate\Database\Eloquent\SoftDeletes;

trait MySoftDeletes
{

    use SoftDeletes;

    public function beingFullyDeleted()
    {
        return $this->forceDeleting;
    }

}