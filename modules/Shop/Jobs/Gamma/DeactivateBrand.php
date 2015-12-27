<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;

/**
 * Class DeactivateBrand
 * @package Modules\Shop\Jobs\Gamma
 */
class DeactivateBrand extends Job
{
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
     * @param GammaNotification $notifications
     */
    public function handle(GammaNotification $notifications)
    {
        $processingOrExisting = $notifications->where('brand_id', $this->brand->id)
            ->count();

        if ($processingOrExisting) {
            $message = "can't deactivate, something is still being processed";

            abort(400, $message, ['statustext' => $message]);
        }

        if ($this->brand->selection) {
            $this->brand->selection->delete();
        }
    }
}
