<?php

namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\CategorySelection;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Category;

/**
 * Class NotifyCategoryGlobalDeactivation
 * @package Modules\Shop\Jobs\Gamma\Notification
 */
class NotifyCategoryGlobalDeactivation extends Job
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

    /**
     * @param Category $category
     * @param Account $account
     */
    public function __construct(Category $category, Account $account)
    {
        $this->account = $account;
        $this->category = $category;
    }

    /**
     * @param GammaNotification $notification
     */
    public function handle(GammaNotification $notification)
    {
        $this->category->selection->delete();

        foreach ($this->category->brands as $brand) {
            $existing = $this->findExistingCombination($notification, $brand, $this->category);

            if ($existing) {
                $existing->delete();
            } else {
                $instance = $notification->newInstance([
                    'account_id' => $this->account->id,
                    'category_id' => $this->category->id,
                    'brand_id' => $brand->id,
                    'type' => CategorySelection::DEACTIVATE,
                ]);

                $instance->save();
            }
        }
    }

    /**
     * @param GammaNotification $notification
     * @param $brand
     * @param $category
     * @return
     */
    protected function findExistingCombination(GammaNotification $notification, $brand, $category)
    {
        $existing = $notification
            ->where('brand_id', $brand->id)
            ->where('category_id', $category->id)->first();

        return $existing;
    }
}
