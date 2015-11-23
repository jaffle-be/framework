<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\CategorySelection;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaRepositoryInterface;
use Modules\Shop\Product\Category;
use Pusher;

class NotifyCategoryActivation extends Job implements SelfHandling
{

    use GammaNotificationHelpers;

    /**
     * @var
     */
    protected $account;

    /**
     * @var
     */
    protected $category;

    public function __construct(Account $account, Category $category)
    {
        $this->account = $account;
        $this->category = $category;
    }

    public function handle(GammaRepositoryInterface $gamma, GammaNotification $notification, Pusher $pusher)
    {
        $brands = $gamma->brandsForCategory($this->category);

        foreach ($brands as $brand) {
            $canceled = $this->cancelInverseNotifications($notification, $brand, $this->category, $pusher);

            if ($canceled === 0) {
                $instance = $notification->newInstance([
                    'account_id'            => $this->account->id,
                    'category_id'           => $this->category->id,
                    'brand_id'              => $brand->id,
                    'type'                  => CategorySelection::ACTIVATE,
                ]);

                $instance->save();
            }
        }
    }

}