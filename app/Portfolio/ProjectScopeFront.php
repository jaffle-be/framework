<?php namespace App\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class ProjectScopeFront implements ScopeInterface
{

    public function apply(Builder $query, Model $model)
    {
        $query->whereHas('translations', function($query){

            $query->where('locale', app()->getLocale())
                ->where('published', 1);
        });
    }

    public function remove(Builder $query, Model $model)
    {

    }

}