<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use Modules\Shop\Gamma\GammaNotification;

trait GammaNotificationHelpers
{

    protected function cancelExisting($notification, $brand, $category)
    {
        return $notification->where('brand_id', $brand->id)
            ->where('category_id', $category->id)
            ->delete();
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