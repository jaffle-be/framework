<?php

namespace Modules\Blog;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PostTranslationScopeFront implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     *
     *
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('locale', app()->getLocale())
            ->where('publish_at', '<', 'now()');
    }
}
