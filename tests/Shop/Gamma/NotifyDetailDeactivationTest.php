<?php

namespace Test\Shop\Gamma;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Jobs\Gamma\Notification\NotifyDetailDeactivation;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Test\AdminTestCase;

class NotifyDetailDeactivationTest extends AdminTestCase
{
    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage this gamma detail is still being processed
     */
    public function testItAbortsDeactivationWhenStuffStillBeingProcessed()
    {
        $brand = factory(Brand::class)->create();
        $category = factory(Category::class)->create();
        $account = factory(Account::class)->create();

        //stuff still being processed means a notification with same parameters
        factory(GammaNotification::class, 'activate')->create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'account_id' => $account->id,
            'processing' => true,
        ]);

        $this->execute($brand, $category, $account);
    }

    public function testItAddsNotificationWhenNotCancelledTheInverse()
    {
        $brand = factory(Brand::class)->create();
        $account = factory(Account::class)->create();
        $category = factory(Category::class)->create();

        $this->execute($brand, $category, $account);

        $this->seeInDatabase('product_gamma_notifications', [
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'account_id'  => $account->id,
            'type'        => 'deactivate',
        ]);
    }

    public function testItDoesntAddNotificationWhenCancelledTheInverse()
    {
        $brand = factory(Brand::class)->create();
        $account = factory(Account::class)->create();
        $category = factory(Category::class)->create();

        $notification = factory(GammaNotification::class, 'activate')->create([
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'account_id'  => $account->id,
        ]);

        $this->execute($brand, $category, $account);

        $this->notSeeInDatabase('product_gamma_notifications', ['id' => $notification->id]);
        $this->notSeeInDatabase('product_gamma_notifications', [
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'account_id'  => $account->id,
            'type'        => 'deactivate',
        ]);
    }

    /**
     * @param $brand
     * @param $category
     * @param $account
     */
    protected function execute($brand, $category, $account)
    {
        $job = new NotifyDetailDeactivation($brand, $category, $account);
        $job->handle(new GammaNotification(), app('Pusher'));
    }
}
