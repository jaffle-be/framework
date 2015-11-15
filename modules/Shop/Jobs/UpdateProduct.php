<?php namespace Modules\Shop\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Shop\Product\Product;

class UpdateProduct extends Job implements SelfHandling
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
        $this->post = $product;
        $this->input = $input;
    }

    public function handle()
    {
        $this->post->fill($this->input);

        return $this->post->save() ? $this->post : false;
    }

}