<?php namespace Modules\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class PostScopeFront implements ScopeInterface
{

    public function apply(Builder $query, Model $model)
    {
        $query->join('post_translations', function($join){
            $join->on('posts.id', '=', 'post_translations.post_id')
                ->where('post_translations.locale', '=', app()->getLocale())
                ->where('post_translations.publish_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
        });

        $query->select(['posts.*']);
    }

    public function remove(Builder $query, Model $model)
    {

    }

}