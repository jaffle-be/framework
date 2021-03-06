<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Gamma\BrandSelection;
use Modules\Shop\Product\Brand;

/**
 * Class ActivateBrand
 * @package Modules\Shop\Jobs\Gamma
 */
class ActivateBrand extends Job
{
    use DispatchesJobs;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @param Brand $brand
     * @param Account $account
     */
    public function __construct(Brand $brand, Account $account)
    {
        $this->brand = $brand;
        $this->account = $account;
    }

    /**
     * @param BrandSelection $selection
     */
    public function handle(BrandSelection $selection)
    {
        $instance = $selection->newInstance(['account_id' => $this->account->id]);

        //create the selections
        $this->brand->selection()->save($instance);
    }
}
