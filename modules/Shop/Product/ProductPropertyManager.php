<?php namespace Modules\Shop\Product;

class ProductPropertyManager
{
    protected $product;

    protected $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function detach($payload)
    {
        $product = $this->product->find($payload['product_id']);
        $category = $this->category->find($payload['category_id']);

        if(!$category->original_id)
        {
            $product->properties()->delete();
        }
    }

}