<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaRepositoryInterface;
use Modules\Shop\Product\Brand;
use Pusher;

class NotifyBrandActivation extends Job
{

    use GammaNotificationHelpers;

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

    public function handle(GammaRepositoryInterface $gamma, GammaNotification $notification, Pusher $pusher)
    {
        $categories = $gamma->categoriesForBrand($this->brand);

        foreach ($categories as $category) {
            $canceled = $this->cancelInverseNotifications($notification, $this->account, $this->brand, $category, $pusher);

            if ($canceled === 0) {
                $instance = $notification->newInstance([
                    'account_id'         => $this->account->id,
                    'category_id'        => $category->id,
                    'brand_id'           => $this->brand->id,
                    'type'               => 'activate',
                ]);

                $instance->save();
            }
        }
    }

}