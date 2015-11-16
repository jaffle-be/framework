<?php namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

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

                $this->cancelNotifications($notifications, 'deactivate');

                break;
            case 'deactivate':
                $this->notifyWithinScope($catalog, $productGamma, 'deactivate');

                $this->cancelNotifications($notifications, 'activate');

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

            $records = $selections->newQueryWithoutScopes()
                ->where('account_id', $notification->account_id)
                ->whereIn('product_id', $products->lists('id')->toArray())
                ->get()->keyBy('product_id');

            foreach ($products as $product) {

                $notificationPayload = [
                    'product_id'  => $product->id,
                    'category_id' => $notification->category->id,
                    'brand_id'    => $notification->brand->id,
                    'account_id'  => $notification->account->id,
                    'type'        => $status,
                ];

                $record = $records->get($product->id);

                //when notifying, we do not want to generate a warning for something that's already in that status.
                if ($status == 'activate' && (!$record || $record->deleted_at)) {
                    $notification->create($notificationPayload);
                } elseif ($status == 'deactivate' && ($record && !$record->deleted_at)) {
                    $notification->create($notificationPayload);
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

    protected function cancelNotifications(GammaNotification $notifications, $status)
    {
        $existing = $notifications->whereNotNull('product_id')
            ->notBeingProcessed()
            ->where('category_id', $this->notification->category->id)
            ->where('brand_id', $this->notification->brand->id)
            ->where('type', $status)
            ->get();

        foreach ($existing as $notification) {
            $notification->delete();
        }
    }
}