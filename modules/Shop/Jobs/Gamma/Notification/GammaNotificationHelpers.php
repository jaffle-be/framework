<?php

namespace Modules\Shop\Jobs\Gamma\Notification;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Pusher;

trait GammaNotificationHelpers
{
    protected function beingProcessed(GammaNotification $notification, Account $account, Brand $brand, Category $category)
    {
        return $notification->newQueryWithoutScopes()
            ->where('account_id', $account->id)
            ->where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->beingProcessed()
            ->count() > 0;
    }

    protected function cancelInverseNotifications(GammaNotification $notification, Account $account, Brand $brand, Category $category, Pusher $pusher)
    {
        $notifications = $notification
            ->newQueryWithoutScopes()
            ->where('account_id', $account->id)
            ->where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->whereNull('product_id')
            ->notBeingProcessed()
            ->get();

        $counter = 0;

        foreach ($notifications as $notification) {
            $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $notification->toArray());

            $notification->delete();
            ++$counter;
        }

        return $counter;
    }

    /**
     * @return mixed
     */
    protected function findExistingCombination(GammaNotification $notification, Account $account, Brand $brand, Category $category)
    {
        $existing = $notification->newQueryWithoutScopes()
            ->where('account_id', $account->id)
            ->where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->notBeingProcessed()
            ->first();

        return $existing;
    }
}
