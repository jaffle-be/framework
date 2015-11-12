<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
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

    public function handle(GammaNotification $notifications)
    {
        $processingOrExisting = $notifications->where('brand_id', $this->brand->id)
            ->count();

        if($processingOrExisting)
        {
            $message = "can't deactivate, something is still being processed";

            abort(400, $message, ['statustext' => $message]);
        }

        if($this->brand->selection)
        {
            $this->brand->selection->delete();
        }
    }
}