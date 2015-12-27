<?php

namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ModelAutoSortScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        $field = 'sort';

        $order = 'asc';

        if (property_exists(get_class($model), 'autosort')) {
            $autosort = (array) $model->autosort;

            $field = $autosort[0];

            $order = isset($autosort[1]) ? $autosort[1] : $order;
        }

        $builder->orderBy($field, $order);
    }
}
