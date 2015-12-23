<?php namespace Test\Shop\Gamma;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery as m;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\AcceptGammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\BatchGammaActivation;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\BatchGammaDeactivation;
use Test\AdminTestCase;

class AcceptGammaNotificationTest extends AdminTestCase
{
    use DispatchesJobs;

    public function testAcceptingABatchActivation()
    {
        $notification = new GammaNotification([
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'activate',
        ]);

        $notification->save();

        $this->expectsJobs([BatchGammaActivation::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }


    public function testAcceptingAProductActivation()
    {
        $notification = new GammaNotification([
            'product_id' => 1,
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'activate',
        ]);

        $notification->save();

        $this->expectsJobs([ActivateProduct::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }

    public function testAcceptingABatchDeactivation()
    {
        $notification = new GammaNotification([
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'deactivate',
        ]);

        $notification->save();

        $this->expectsJobs([BatchGammaDeactivation::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }

    public function testAcceptingAProductDeactivation()
    {
        $notification = new GammaNotification([
            'product_id' => 1,
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'deactivate',
        ]);

        $notification->save();

        $this->expectsJobs([DeactivateProduct::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }

    protected function handleJob($job)
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('trigger');
        $job->handle($pusher);
    }

}