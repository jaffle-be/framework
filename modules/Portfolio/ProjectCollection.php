<?php

namespace Modules\Portfolio;

use Illuminate\Database\Eloquent\Collection;
use Modules\Tags\CollectionWithTaggables;

class ProjectCollection extends Collection
{

    use CollectionWithTaggables;
}
