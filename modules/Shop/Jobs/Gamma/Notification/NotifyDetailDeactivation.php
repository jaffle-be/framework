<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Pusher;

class NotifyDetailDeactivation extends Job
{

    use GammaNotificationHelpers;

    protected $brand;

    protected $category;

    protected $account;

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

        //did we already have a brand activation notification for this brand?
        //then we simply delete it.
        //if not, we'create one
        $existing = $this->findExistingCombination($notification, $this->account, $this->brand, $this->category);

        if ($existing) {
            $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $existing->toArray());
            $existing->delete();
        } else {
            $instance = $notification->newInstance([
                'account_id'            => $this->account->id,
                'category_id'           => $this->category->id,
                'brand_id'              => $this->brand->id,
                'type'                  => 'deactivate',
            ]);

            $instance->save();
        }
    }

}