<?php

namespace Modules\Pages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class PageTranslationScopeFront
 * @package Modules\Pages
 */
class PageTranslationScopeFront implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('locale', app()->getLocale())
            ->where('published', 1);
    }
}
