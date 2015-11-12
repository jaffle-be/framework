<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Pusher;

class ReviewGammaNotification extends Job implements SelfHandling, ShouldQueue
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
                $this->insertNewGammaSelection($gamma, $notification);

                $this->notifyWithinScope($catalog, $productGamma, 'activate');

                break;
            case 'deactivate':
                $this->deleteExistingGammaSelection($gamma, $notification);

                $this->notifyWithinScope($catalog, $productGamma, 'deactivate');

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

    /**
     * @param CatalogRepositoryInterface $catalog
     * @param                            $status
     */
    protected function notifyWithinScope(CatalogRepositoryInterface $catalog, ProductSelection $selections, $status)
    {
        $notification = $this->notification;

        $callback = function ($products) use ($notification, $selections, $status) {

            //when notifying, we do not want to generate a warning for something that's already in that status.
            $records = $selections->newQuery()->withTrashed()
                ->whereIn('product_id', $products->lists('id')->toArray())
                ->lists('product_id')->get()->keyBy('product_id');

            foreach ($products as $product) {

                if($status == 'activate')
                {
                    $record = $records->get($product->id);

                    //currently inactive
                    //no record ,
                    //or a trashed record
                    if(!$record || $record->deleted_at)
                    {
                        $notificationPayload = [
                            'product_id'  => $product->id,
                            'category_id' => $notification->category->id,
                            'brand_id'    => $notification->brand->id,
                            'account_id'  => $notification->account->id,
                            'type'        => $status,
                        ];

                        $productNotification = $notification->newInstance($notificationPayload);
                        $productNotification->save();
                    }
                }
                else{

                    //active means
                    //a record which is not trashed.
                    if($record && !$record->deleted_at)
                    {
                        $notificationPayload = [
                            'product_id'  => $product->id,
                            'category_id' => $notification->category->id,
                            'brand_id'    => $notification->brand->id,
                            'account_id'  => $notification->account->id,
                            'type'        => $status,
                        ];

                        $productNotification = $notification->newInstance($notificationPayload);
                        $productNotification->save();
                    }
                }
            }
        };

        $catalog->chunkWithinBrandCategory($notification->brand, $notification->category, $callback);
    }

    /**
     * @param GammaSelection $gamma
     * @param                $notification
     */
    protected function deleteExistingGammaSelection(GammaSelection $gamma, $notification)
    {
        $selections = $gamma->where(['category_id' => $notification->category->id, 'brand_id' => $notification->brand->id])->get();

        foreach ($selections as $selection) {
            $selection->delete();
        }
    }

}