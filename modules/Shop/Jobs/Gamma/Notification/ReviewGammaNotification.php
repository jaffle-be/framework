<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Pusher;

class ReviewGammaNotification extends Job implements SelfHandling
{

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(GammaSelection $gamma, Pusher $pusher)
    {
        //we should put all products online within this scope.
        $brand = $this->notification->brand;
        $category = $this->notification->category;
        $account = $this->notification->account;

        switch($this->notification->type)
        {
            case 'activate':
                //insert this as a gamma selection
                $selection = $gamma->newInstance(['category_id' => $category->id, 'brand_id' => $brand->id, 'account_id' => $account->id]);
                $selection->save();
                //we should generate a notification for all products within this scope.
                break;
            case 'deactivate':
                //insert this as a gamma selection
                $selections = $gamma->where(['category_id' => $category->id, 'brand_id' => $brand->id])->get();

                foreach($selections as $selection)
                {
                    $selection->delete();
                }

                //we should generate a notification for all products within this scope.
                break;
        }

        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.confirmed', $this->notification->toArray());
        $this->notification->delete();
    }

}