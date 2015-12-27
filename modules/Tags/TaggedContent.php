<?php

namespace Modules\Tags;

use Illuminate\Database\Eloquent\Model;

/**
 * This class is mostly used as a helper to define an intermediate relation to the taggables table.
 * Example, when checking if a tag is still being used (to any of it's possible types|models that can be tagged
 * you should either check each possible relation
 * or use the intermediate relation which will be only one query.
 * Class TaggedContent
 */
class TaggedContent extends Model
{

    protected $table = 'taggables';

    public function taggable()
    {
        return $this->morphTo();
    }
}
