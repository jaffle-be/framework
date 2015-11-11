<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Pusher;

trait GammaNotificationHelpers
{

    protected function cancelExisting(GammaNotification $notification, Brand $brand, Category $category, Pusher $pusher)
    {
        $notifications = $notification->where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->get();

        $counter = 0;

        foreach($notifications as $notification)
        {
            $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $notification->toArray());

            $notification->delete();
            $counter++;
        }

        return $counter;
    }

    /**
     * @param GammaNotification $notification
     * @param                   $brand
     * @param                   $category
     *
     * @return mixed
     */
    protected function findExistingCombination(GammaNotification $notification, $brand, $category)
    {
        $existing = $notification
            ->whereHas('brandSelection', function ($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })
            ->whereHas('categorySelection', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->first();

        return $existing;
    }

}