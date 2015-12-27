<?php

namespace Modules\Portfolio;

use Illuminate\Database\Eloquent\Collection;
use Modules\Tags\CollectionWithTaggables;

/**
 * Class ProjectCollection
 * @package Modules\Portfolio
 */
class ProjectCollection extends Collection
{
    use CollectionWithTaggables;
}
