<?php

namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\AcceptGammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\DenyGammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\ReviewGammaNotification;
use Modules\System\Http\AdminController;

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

        foreach ($requested as $notification) {
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

        foreach ($requested as $notification) {
            //we start the processing
            $notification->processing = true;
            $notification->save();

            //the job itself gets queued
            $this->dispatch(new ReviewGammaNotification($notification));
            //processing jobs shouldn't be shown in the UI.
        }

        return $this->refreshedPageData($notifications, $request);
    }

    public function deny(GammaNotification $notifications, Request $request)
    {
        $requested = $this->requestedNotifications($notifications, $request);

        foreach ($requested as $notification) {
            $notification->processing = true;
            $notification->save();

            $this->dispatch(new DenyGammaNotification($notification));
        }

        return $this->refreshedPageData($notifications, $request);
    }

    protected function refreshedPageData($notifications, Request $request)
    {
        $relations = ['brand', 'brand.translations', 'category', 'category.translations', 'product', 'product.translations'];

        $result = $notifications->notBeingProcessed()->with($relations)->orderBy('created_at', 'asc')->paginate(50);

        if ($result->count() < 0 && $request->get('page') > 1) {
            $request->put('page', 1);

            return $notifications->notBeingProcessed()->with($relations)->orderBy('created_at', 'asc')->paginate(50);
        }

        return $result;
    }

    /**
     *
     *
     *
     * @return GammaNotification
     */
    protected function requestedNotifications(GammaNotification $notifications, Request $request)
    {
        $notifications = $notifications->whereIn('id', $request->get('notifications'))->get();

        return $notifications;
    }
}
