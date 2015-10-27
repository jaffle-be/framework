<?php namespace Modules\Portfolio;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class ProjectScopeFront implements ScopeInterface
{

    public function apply(Builder $query, Model $model)
    {
        $query->has('translations');
    }

    public function remove(Builder $query, Model $model)
    {

    }

}