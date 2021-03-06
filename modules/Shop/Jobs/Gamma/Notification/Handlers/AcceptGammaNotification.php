<?php

namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Pusher;

/**
 * Class AcceptGammaNotification
 * @package Modules\Shop\Jobs\Gamma\Notification\Handlers
 */
class AcceptGammaNotification extends Job implements ShouldQueue
{
    use DispatchesJobs;

    protected $notification;

    /**
     * @param GammaNotification $notification
     */
    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param Pusher $pusher
     */
    public function handle(Pusher $pusher)
    {
        if ($this->activating()) {
            if ($this->isProductSpecific()) {
                $job = new ActivateProduct($this->notification->product, $this->notification->category, $this->notification->account);
            } else {
                $job = new BatchGammaActivation($this->notification->category, $this->notification->account, $this->notification->brand);
            }
        } else {
            if ($this->isProductSpecific()) {
                $job = new DeactivateProduct($this->notification->product, $this->notification->category, $this->notification->account);
            } else {
                $job = new BatchGammaDeactivation($this->notification->category, $this->notification->account, $this->notification->brand);
            }
        }

        $this->dispatch($job);

        $this->finish($pusher);

        $this->cleanup();
    }

    /**
     *
     */
    protected function isProductSpecific()
    {
        return $this->notification->product;
    }

    protected function cleanup()
    {
        $this->dispatch(new CleanupDetail($this->notification->brand, $this->notification->category, $this->notification->account));
    }

    /**
     * @return bool
     */
    protected function activating()
    {
        return $this->notification->type == 'activate';
    }

    /**
     * @param Pusher $pusher
     * @throws \Exception
     */
    protected function finish(Pusher $pusher)
    {
        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.confirmed', $this->notification->toArray());

        $this->notification->delete();
    }
}
