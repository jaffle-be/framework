<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;

use Modules\Shop\Product\Product;

class UpdateProduct extends Job
{

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
    }

}