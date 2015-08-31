<?php namespace App\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class PostScopeFront implements ScopeInterface
{

    public function apply(Builder $query, Model $model)
    {
        $query->has('translations');
    }

    public function remove(Builder $query, Model $model)
    {

    }

}