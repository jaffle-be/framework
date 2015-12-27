<?php

namespace Modules\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class PostScopeFront
 * @package Modules\Blog
 */
class PostScopeFront implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->join('post_translations', function ($join) {
            $join->on('posts.id', '=', 'post_translations.post_id')
                ->where('post_translations.locale', '=', app()->getLocale())
                ->where('post_translations.publish_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
        });

        $builder->select(['posts.*']);
    }
}
