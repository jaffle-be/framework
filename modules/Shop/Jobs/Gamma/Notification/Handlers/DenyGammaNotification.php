<?php namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Pusher;

class DenyGammaNotification extends Job implements ShouldQueue, SelfHandling
{
    use DispatchesJobs;

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(Pusher $pusher, GammaSelection $gamma, ProductSelection $selections)
    {
        if($this->notification->product && $this->notification->type == 'deactivate')
        {
            //when denying a deactivating of a product, we need to make sure the combination is still selected
            $exists = $gamma->where('category_id', $this->notification->category->id)
                ->where('brand_id', $this->notification->brand->id)
                ->first();

            if(!$exists)
            {
                $gamma->create([
                    'account_id' => $this->notification->account_id,
                    'brand_id' => $this->notification->brand_id,
                    'category_id' => $this->notification->category_id,
                ]);
            }
        }

        if($this->notification->product && $this->notification->type == 'activate')
        {
            //when denying an activation, we should make sure the record is there
            //so we trigger a deactivate instead.
            $this->dispatch(new DeactivateProduct($this->notification->product, $this->notification->category, $this->notification->account));

            if($selections->countActiveProducts($this->notification->brand_id, $this->notification->category_id) == 0)
            {
                $this->dispatch(new CleanupDetail($this->notification->brand, $this->notification->category, $this->notification->account));
            }
        }

        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $this->notification->toArray());

        $this->notification->delete();
    }

}