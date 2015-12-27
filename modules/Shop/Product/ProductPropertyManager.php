<?php

namespace Modules\Shop\Product;

/**
 * Class ProductPropertyManager
 * @package Modules\Shop\Product
 */
class ProductPropertyManager
{
    protected $product;

    protected $category;

    /**
     * @param Product $product
     * @param Category $category
     */
    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    /**
     * @param $payload
     */
    public function detach($payload)
    {
        $product = $this->product->find($payload['product_id']);
        $category = $this->category->find($payload['category_id']);

        if (! $category->original_id) {
            $product->properties()->delete();
        }
    }
}
