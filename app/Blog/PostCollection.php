<?php namespace App\Blog;

use App\Media\ImageOwners;
use Illuminate\Database\Eloquent\Collection;

class PostCollection extends Collection
{

    use ImageOwners;

}