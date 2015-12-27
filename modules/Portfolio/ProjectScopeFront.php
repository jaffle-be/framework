<?php

namespace Modules\Portfolio;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class ProjectScopeFront
 * @package Modules\Portfolio
 */
class ProjectScopeFront implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->join('portfolio_project_translations', function ($join) {
            $join->on('portfolio_projects.id', '=', 'portfolio_project_translations.project_id')
                ->where('portfolio_project_translations.locale', '=', app()->getLocale())
                ->where('portfolio_project_translations.published', '=', 1);
        });

        $builder->select(['portfolio_projects.*']);
    }
}
