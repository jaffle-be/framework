<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProductScopeFront implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model   $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->join('product_translations', function ($join) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.locale', '=', app()->getLocale())
                ->where('product_translations.published', '=', 1);
        });

        $builder->select(['products.*']);
    }
}
