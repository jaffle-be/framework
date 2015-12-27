<?php

namespace Modules\Tags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Taggable
{

    public function tags()
    {
        return $this->morphToMany('Modules\Tags\Tag', 'taggable');
    }

    public function scopeTaggedWith(Builder $builder, Collection $tags)
    {
        /** @var MorphToMany $relation */
        $relation = $this->tags();

        $key = $this->getTable() . '.' . $this->getKeyName();

        if ($tags->count()) {
            $builder->join($relation->getTable(), function ($join) use ($relation, $key, $tags) {

                $join->on($relation->getForeignKey(), '=', $key);
                $join->where($relation->getMorphType(), '=', $relation->getMorphClass());
                $join->whereIn($relation->getOtherKey(), $tags->keys()->toArray());
            });
        } else {
            $builder->whereNull($this->getTable());
        }

        return $builder;
    }
}
