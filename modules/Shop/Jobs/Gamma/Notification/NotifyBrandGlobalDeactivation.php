<?php

namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;

/**
 * Class NotifyBrandGlobalDeactivation
 * @package Modules\Shop\Jobs\Gamma\Notification
 */
class NotifyBrandGlobalDeactivation extends Job
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

    /**
     * @param Brand $brand
     * @param Account $account
     */
    public function __construct(Brand $brand, Account $account)
    {
        $this->account = $account;
        $this->brand = $brand;
    }

    /**
     * @param GammaNotification $notification
     */
    public function handle(GammaNotification $notification)
    {
        $this->brand->selection->delete();

        foreach ($this->brand->categories as $category) {

            //did we already have a brand activation notification for this brand?
            //then we simply cancel that it by deleting it.
            //if not, we're allowed to create the record.

            $existing = $this->findExistingCombination($notification, $this->brand, $category);

            if ($existing) {
                $existing->delete();
            } else {
                $instance = $notification->newInstance([
                    'account_id' => $this->account->id,
                    'brand_id' => $this->brand->id,
                    'category_id' => $category->id,
                    'type' => 'deactivate',
                ]);

                $instance->save();
            }
        }
    }
}
