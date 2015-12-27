<?php namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SiteSluggableScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->join('uris', function ($join) use ($model) {
            $join->where('uris.owner_type', '=', get_class($model));
            $join->on('uris.owner_id', '=', $model->getTable() . '.' . $model->getKeyName());
        })->select([
            $model->getTable() . '.*',
            'uris.uri',
        ]);
    }

}