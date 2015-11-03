<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Shop\Product\Product;

class DeactivateProduct extends Job implements SelfHandling
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