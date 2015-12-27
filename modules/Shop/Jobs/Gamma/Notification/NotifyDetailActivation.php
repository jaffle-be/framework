<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Pusher;

class NotifyDetailActivation extends Job
{

    use GammaNotificationHelpers;

    protected $category;

    protected $account;

    protected $brand;

    public function __construct(Brand $brand, Category $category, Account $account)
    {
        $this->brand = $brand;
        $this->category = $category;
        $this->account = $account;
    }

    public function handle(GammaNotification $notification, Pusher $pusher)
    {
        if ($this->beingProcessed($notification, $this->account, $this->brand, $this->category)) {
            $message = 'this gamma detail is still being processed';

            abort(400, $message, ['statustext' => $message]);
        };

        $canceled = $this->cancelInverseNotifications($notification, $this->account, $this->brand, $this->category, $pusher);

        if ($canceled === 0) {
            $instance = $notification->newInstance([
                'account_id'            => $this->account->id,
                'category_id'           => $this->category->id,
                'brand_id'              => $this->brand->id,
                'type'                  => 'activate',
            ]);

            $instance->save();
        }
    }

}