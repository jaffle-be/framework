<?php

namespace Modules\Shop\Jobs;

use App\Jobs\Job;
use Modules\Shop\Product\Product;

/**
 * Class UpdateProduct
 * @package Modules\Shop\Jobs
 */
class UpdateProduct extends Job
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Product $product
     * @param array $input
     */
    public function __construct(Product $product, array $input)
    {
        $this->product = $product;
        $this->input = $input;
    }

    /**
     * @return bool|Product
     */
    public function handle()
    {
        $this->product->fill($this->input);

        return $this->product->save() ? $this->product : false;
    }
}
