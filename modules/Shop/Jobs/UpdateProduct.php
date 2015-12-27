<?php

namespace Modules\Shop\Jobs;

use App\Jobs\Job;
use Modules\Shop\Product\Product;

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

    public function __construct(Product $product, array $input)
    {
        $this->product = $product;
        $this->input = $input;
    }

    public function handle()
    {
        $this->product->fill($this->input);

        return $this->product->save() ? $this->product : false;
    }
}
