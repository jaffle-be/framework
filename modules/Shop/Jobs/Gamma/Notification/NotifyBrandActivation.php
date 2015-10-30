<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaRepositoryInterface;
use Modules\Shop\Product\Brand;

class NotifyBrandActivation extends Job implements SelfHandling
{

    /**
     * @var
     */
    protected $account;

    /**
     * @var
     */
    protected $brand;

    public function __construct(Account $account, Brand $brand)
    {
        $this->account = $account;
        $this->brand = $brand;
    }

    public function handle(GammaRepositoryInterface $gamma, GammaNotification $notification)
    {
        $categories = $gamma->categoriesForBrand($this->brand);

        foreach($categories as $category)
        {
            $instance = $notification->newInstance([
                'account_id' => $this->account->id,
                'category_id' => $category->id,
                'brand_id' => $this->brand->id,
                'brand_selection_id' => $this->brand->selection->id,
            ]);

            $instance->save();
        }
    }

}