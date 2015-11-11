<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Pusher;

class ReviewGammaNotification extends Job implements SelfHandling
{

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(GammaSelection $gamma, Pusher $pusher, CatalogRepositoryInterface $catalog, ProductSelection $productGamma, GammaNotification $notifications)
    {
        //we should put all products online within this scope.
        $notification = $this->notification;

        switch ($this->notification->type) {
            case 'activate':
                //insert this as a gamma selection
                $this->insertNewGammaSelection($gamma, $notification);
                //we should generate a notification for all products within this scope.

                $catalog->chunkWithinBrandCategory($notification->brand, $notification->category, function ($products) use ($notifications, $notification, $productGamma) {

                    foreach ($products as $product) {

                        $notificationPayload = [
                            'product_id'  => $product->id,
                            'category_id' => $notification->category->id,
                            'brand_id'    => $notification->brand->id,
                            'account_id'  => $notification->account->id,
                            'type'        => 'activate',
                        ];

                        $notification->newInstance($notificationPayload);
                        $notification->save();

                        $this->dispatch(new ActivateProduct($product, $notification->category, $notification->account));
                    }
                });

                break;
            case 'deactivate':
                //insert this as a gamma selection
                $selections = $gamma->where(['category_id' => $notification->category->id, 'brand_id' => $notification->brand->id])->get();

                foreach ($selections as $selection) {
                    $selection->delete();
                }

                //we should generate a notification for all products within this scope.
                break;
        }

        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.confirmed', $this->notification->toArray());
        $this->notification->delete();
    }

    /**
     * @param GammaSelection $gamma
     * @param                $notification
     */
    protected function insertNewGammaSelection(GammaSelection $gamma, $notification)
    {
        $instancePayload = [
            'category_id' => $notification->category->id,
            'brand_id'    => $notification->brand->id,
            'account_id'  => $notification->account->id
        ];

        $selection = $gamma->newInstance($instancePayload);
        $selection->save();
    }

}