<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\BrandSelection;
use Modules\Shop\Product\Brand;

class DeactivateBrand extends Job implements SelfHandling
{

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Brand $brand, Account $account)
    {

        $this->brand = $brand;
        $this->account = $account;
    }

    public function handle(BrandSelection $brands)
    {
        if($this->brand->selection)
        {
            $this->brand->selection->delete();

            $selections = $brands->where('brand_id', $this->brand->id)->get();

            foreach($selections as $selection)
            {
                $selection->delete();
            }
        }
    }
}