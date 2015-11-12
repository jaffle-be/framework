<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Modules\Shop\Jobs\Gamma\Notification\AcceptGammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\ReviewGammaNotification;
use Modules\System\Http\AdminController;
use Pusher;

class NotificationController extends AdminController
{

    public function template()
    {
        return view('shop::admin.notifications.overview');
    }

    public function overview(GammaNotification $notifications, Request $request)
    {
        return $this->refreshedPageData($notifications, $request);
    }

    public function accept(GammaNotification $notifications, Request $request)
    {
        $requested = $this->requestedNotifications($notifications, $request);

        foreach($requested as $notification)
        {
            //we start the processing
            $notification->processing = true;
            $notification->save();

            //the job itself gets queued
            $this->dispatch(new AcceptGammaNotification($notification));

            //processing jobs shouldn't be shown in the UI.
        }

        return $this->refreshedPageData($notifications, $request);
    }

    public function review(GammaNotification $notifications, Request $request)
    {
        $requested = $this->requestedNotifications($notifications, $request);

        foreach($requested as $notification)
        {
            //we start the processing
            $notification->processing = true;
            $notification->save();

            //the job itself gets queued
            $this->dispatch(new ReviewGammaNotification($notification));

            //processing jobs shouldn't be shown in the UI.
        }

        return $this->refreshedPageData($notifications, $request);
    }

    public function deny(GammaNotification $notifications, Request $request, Pusher $pusher, GammaSelection $gamma, ProductSelection $selections)
    {
        $requested = $this->requestedNotifications($notifications, $request);

        foreach($requested as $notification)
        {
            if($notification->product && $notification->type == 'deactivate')
            {
                //when denying a deactivating of a product, we need to make sure the combination is still selected
                $exists = $gamma->where('category_id', $notification->category->id)
                    ->where('brand_id', $notification->brand->id)
                    ->first();

                if(!$exists)
                {
                    $gamma->create([
                        'account_id' => $notification->account_id,
                        'brand_id' => $notification->brand_id,
                        'category_id' => $notification->category_id,
                    ]);
                }
            }

            if($notification->product && $notification->type == 'activate')
            {
                //when denying an activation, we should make sure the record is there
                //so we trigger a deactivate instead.
                $this->dispatch(new DeactivateProduct($notification->product, $notification->category, $notification->account));

                if($selections->countActiveProducts($notification->brand_id, $notification->category_id) == 0)
                {
                    $this->dispatch(new CleanupDetail($notification->brand, $notification->category, $notification->account));
                }
            }

            $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $notification->toArray());

            $notification->delete();
        }

        return $this->refreshedPageData($notifications, $request);
    }

    protected function refreshedPageData($notifications, Request $request)
    {
        $relations = ['brand', 'brand.translations', 'category', 'category.translations', 'product', 'product.translations'];

        $result = $notifications->notBeingProcessed()->with($relations)->orderBy('created_at', 'asc')->paginate();

        if($result->count() < 0 && $request->get('page') > 1)
        {
            $request->put('page', 1);

            return $notifications->notBeingProcessed()->with($relations)->orderBy('created_at', 'asc')->paginate();
        }

        return $result;
    }

    /**
     * @param GammaNotification $notifications
     * @param Request           $request
     *
     * @return GammaNotification
     */
    protected function requestedNotifications(GammaNotification $notifications, Request $request)
    {
        $notifications = $notifications->whereIn('id', $request->get('notifications'))->get();

        return $notifications;
    }

}