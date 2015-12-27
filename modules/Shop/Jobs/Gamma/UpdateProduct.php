<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Modules\Shop\Product\Product;

/**
 * Class UpdateProduct
 * @package Modules\Shop\Jobs\Gamma
 */
class UpdateProduct extends Job
{
    protected $product;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
    }
}
