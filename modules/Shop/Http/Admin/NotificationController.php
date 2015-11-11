<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Gamma\GammaNotification;
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

    public function overview(GammaNotification $notifications)
    {
        return $notifications->with(['brand', 'brand.translations', 'category', 'category.translations'])->orderBy('created_at', 'asc')->paginate();
    }

    public function accept(GammaNotification $notifications, Request $request)
    {
        $notifications = $notifications->whereIn('id', $request->get('notifications'))->get();

        foreach($notifications as $notification)
        {
            $this->dispatch(new AcceptGammaNotification($notification));
        }
    }

    public function review(GammaNotification $notifications, Request $request)
    {
        $notifications = $notifications->whereIn('id', $request->get('notifications'))->get();

        foreach($notifications as $notification)
        {
            $this->dispatch(new ReviewGammaNotification($notification));
        }
    }

    public function deny(GammaNotification $notifications, Request $request, Pusher $pusher)
    {
        $notifications = $notifications->whereIn('id', $request->get('notifications'))->get();

        foreach($notifications as $notification)
        {
            $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $notification->toArray());

            $notification->delete();
        }
    }

}