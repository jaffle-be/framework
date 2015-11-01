<?php namespace Modules\Shop\Product;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

class BrandCategoryManager
{

    /**
     * @var Connection
     */
    protected $database;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Brand
     */
    protected $brand;

    public function __construct(DatabaseManager $database, Dispatcher $events, Product $product, Brand $brand)
    {
        //this needs to run on the very basic level, therefor we need the database connection.
        //can't rely on the models, as those will be having scopes.
        //the table here is a table that shows existing links between brands and categories.
        //it should not be influenced by the fact that a product is or is not part of the retailers gamma.
        $this->database = $database;
        //that does mean we need to manually trigger our eloquent events, so pushables get triggered too.
        $this->events = $events;
        $this->product = $product;
        $this->brand = $brand;
    }

    public function attach()
    {
        foreach (func_get_args() as $attached) {
            $product = $this->findProduct($attached);

            if ($product) {

                if (!$this->combinationIsKnown($product, $attached['category_id'])) {

                    $payload = [
                        'brand_id'    => $product['brand_id'],
                        'category_id' => $attached['category_id'],
                    ];

                    $this->brandCombinations()->insert($payload);

                    $this->events->fire('eloquent.attached: brand_category', [$payload]);
                }
            }
        }
    }

    public function detach()
    {
        foreach (func_get_args() as $detached) {
            $product = $this->findProduct($detached);
            //need to check if there is still a product with this association
            //if not -> delete it for the brands too
            if (!$this->combinationStillExists($product, $detached['category_id'])) {

                $this->brandCombinations()->where('category_id', $detached['category_id'])
                    ->where('brand_id', $product['brand_id'])
                    ->delete();

                $payload = [
                    'category_id' => $detached['category_id'],
                    'brand_id'    => $product['brand_id']
                ];
                $this->events->fire('eloquent.detached: brand_category', [$payload]);
            }
        }
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function bareProducts()
    {
        $products = $this->database->table($this->product->getTable());

        return $products;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function brandCombinations()
    {
        $brands = $this->database->table($this->brand->categories()->getTable());

        return $brands;
    }

    /**
     * @param $brands
     * @param $product
     *
     * @return mixed
     */
    protected function combinationIsKnown($product, $category)
    {
        $brands = $this->brandCombinations();

        $brandKey = $this->brand->categories()->getForeignKey();
        $categoryKey = $this->brand->categories()->getOtherKey();

        $brand = $brands->where($brandKey, $product['brand_id'])
            ->where($categoryKey, $category)
            ->first();

        return $brand;
    }

    /**
     * @param $attached
     *
     * @return array
     */
    protected function findProduct($attached)
    {
        //load the product use the core table
        $products = $this->bareProducts();

        $product = (array)$products->where($this->product->getKeyName(), $attached['product_id'])->first();

        return $product;
    }

    protected function combinationStillExists($product, $category_id)
    {
        $products = $this->bareProducts();

        $count = $products->where('brand_id', $product['brand_id'])
            ->join($this->product->categories()->getTable(), $this->product->categories()->getForeignKey(), '=', $this->product->getKeyName())
            ->where($this->product->categories()->getOtherKey(), $category_id)
            ->count();

        return $count > 0;
    }

}