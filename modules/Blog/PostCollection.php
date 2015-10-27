<?php namespace Modules\Blog;

use Illuminate\Database\Eloquent\Collection;
use Modules\Media\ImageOwners;

class PostCollection extends Collection
{

    use ImageOwners;

}