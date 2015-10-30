<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Gamma\BrandSelection;
use Modules\Shop\Gamma\GammaManager;
use Modules\Shop\Jobs\Gamma\Notification\NotifyBrandActivation;
use Modules\Shop\Product\Brand;

class ActivateBrand extends Job implements SelfHandling
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

    public function __construct(Brand $brand, Account $account)
    {
        $this->brand = $brand;
        $this->account = $account;
    }

    public function handle(BrandSelection $selection)
    {
        $instance = $selection->newInstance(['account_id' => $this->account->id]);

        //create the selections
        $this->brand->selection()->save($instance);

        //create the notifications
        $this->dispatch(new NotifyBrandActivation($this->account, $this->brand));
    }

}