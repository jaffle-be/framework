<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;

class ReviewGammaNotification extends Job implements SelfHandling
{

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(GammaSelection $selection)
    {
        //we should put all products online within this scope.
        $brand = $this->notification->brand;
        $category = $this->notification->category;
        $account = $this->notification->account;

        //insert this as a gamma selection
        $selected = $selection->newInstance(['category_id' => $category->id, 'brand_id' => $brand->id, 'account_id' => $account->id]);
        $selected->save();
        //we should generate a notification for all products within this scope.
    }

}