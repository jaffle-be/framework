<?php

namespace Modules\Blog;

use Illuminate\Database\Eloquent\Collection;
use Modules\Media\ImageOwners;

/**
 * Class PostCollection
 * @package Modules\Blog
 */
class PostCollection extends Collection
{
    use ImageOwners;
}
