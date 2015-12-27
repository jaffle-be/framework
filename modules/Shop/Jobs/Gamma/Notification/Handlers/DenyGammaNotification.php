<?php namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Pusher;

class DenyGammaNotification extends Job implements ShouldQueue
{

    use DispatchesJobs;

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(Pusher $pusher, GammaSelection $gamma)
    {
        if ($this->isProductDeactivation()) {
            $this->denyDeactivation($gamma);
        }

        if ($this->isProductActivation()) {
            //when denying an activation, we should make sure the record is there
            //so we trigger a deactivate instead.
            $this->deactivateProduct();
        }

        $this->finish($pusher);

        $this->cleanup();
    }

    /**
     * @return bool
     */
    protected function isProductActivation()
    {
        return $this->notification->product && $this->notification->type == 'activate';
    }

    /**
     * @param GammaSelection $gamma
     */
    protected function denyDeactivation(GammaSelection $gamma)
    {
        //when denying a deactivating of a product, we need to make sure the combination is still selected
        $exists = $gamma->where('category_id', $this->notification->category->id)
            ->where('brand_id', $this->notification->brand->id)
            ->first();

        if (!$exists) {
            $gamma->create([
                'account_id'  => $this->notification->account_id,
                'brand_id'    => $this->notification->brand_id,
                'category_id' => $this->notification->category_id,
            ]);
        }
    }

    /**
     * @return bool
     */
    protected function isProductDeactivation()
    {
        return $this->notification->product && $this->notification->type == 'deactivate';
    }

    protected function deactivateProduct()
    {
        $this->dispatch(new DeactivateProduct($this->notification->product, $this->notification->category, $this->notification->account));
    }

    /**
     * @param Pusher $pusher
     *
     * @throws \Exception
     */
    protected function finish(Pusher $pusher)
    {
        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.denied', $this->notification->toArray());

        $this->notification->delete();
    }

    protected function cleanup()
    {
        $this->dispatch(new CleanupDetail($this->notification->brand, $this->notification->category, $this->notification->account));
    }

}