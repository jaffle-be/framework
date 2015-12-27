<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class ProductScopeFront
 * @package Modules\Shop\Product
 */
class ProductScopeFront implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * @param Builder $builder
     * @param Model $model
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
