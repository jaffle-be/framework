<?php

namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class SiteSluggableScope
 * @package Modules\System\Scopes
 */
class SiteSluggableScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->join('uris', function ($join) use ($model) {
            $join->where('uris.owner_type', '=', get_class($model));
            $join->on('uris.owner_id', '=', $model->getTable().'.'.$model->getKeyName());
        })->select([
            $model->getTable().'.*',
            'uris.uri',
        ]);
    }
}
