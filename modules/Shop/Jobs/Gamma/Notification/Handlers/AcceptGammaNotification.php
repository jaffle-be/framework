<?php namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Pusher;

class AcceptGammaNotification extends Job implements SelfHandling, ShouldQueue
{

    use DispatchesJobs;

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(CatalogRepositoryInterface $catalog, GammaSelection $gamma, ProductSelection $productGamma, Pusher $pusher)
    {
        if($this->activating())
        {
            if ($this->isProductSpecific()) {
                $this->activateProduct();
            } else {
                $this->activateBatch($catalog, $gamma);
            }
        }
        else{
            if ($this->isProductSpecific()) {
                $this->deactivateProduct();
            } else {
                $this->deactivateBatch($productGamma);
            }
        }

        $this->finish($pusher);

        $this->cleanup();
    }

    protected function activateBatch(CatalogRepositoryInterface $catalog, GammaSelection $gamma)
    {
        $notification = $this->notification;

        $this->insertGamma($gamma);

        $catalog->chunkWithinBrandCategory($notification->brand, $notification->category, function ($products) use ($notification) {
            foreach ($products as $product) {
                $this->dispatch(new ActivateProduct($product, $notification->category, $notification->account));
            }
        });
    }

    protected function deactivateBatch(ProductSelection $productGamma)
    {
        $category_id = $this->notification->category->id;
        $brand_id = $this->notification->brand->id;
        $account_id = $this->notification->account->id;

        //chunk alike thinking here
        while ($productGamma->countActiveProducts($brand_id, $category_id, $account_id) > 0) {

            $selections = $productGamma->chunkActiveProducts($brand_id, $category_id, $account_id);

            $selections->load(['categories' => function($query) use ($category_id){
                $query->withTrashed();
            }]);

            foreach ($selections as $selection) {

                $category = $selection->categories->first(function($key, $item) use ($category_id){
                    return $item->category_id == $category_id;
                })->first();

                $category->delete();

                $active = $selection->categories->filter(function($item){
                    return $item->trashed();
                });

                if($active->count() == 0)
                {
                    $selection->delete();
                }
            }
        }
    }

    protected function insertGamma(GammaSelection $gamma)
    {
        //insert this as a gamma selection
        $selected = $gamma->newInstance([
            'category_id' => $this->notification->category->id,
            'brand_id'    => $this->notification->brand->id,
            'account_id'  => $this->notification->account->id
        ]);

        $selected->save();
    }

    /**
     * @return mixed
     */
    protected function isProductSpecific()
    {
        return $this->notification->product;
    }

    /**
     * @return mixed
     */
    protected function activateProduct()
    {
        return $this->dispatch(new ActivateProduct($this->notification->product, $this->notification->category, $this->notification->account));
    }

    /**
     * @return mixed
     */
    protected function deactivateProduct()
    {
        return $this->dispatch(new DeactivateProduct($this->notification->product, $this->notification->category, $this->notification->account));
    }

    protected function cleanup()
    {
        $this->dispatch(new CleanupDetail($this->notification->brand, $this->notification->category, $this->notification->account));
    }

    protected function activating()
    {
        return $this->notification->type == 'activate';
    }

    /**
     * @param Pusher $pusher
     *
     * @throws \Exception
     */
    protected function finish(Pusher $pusher)
    {
        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.confirmed', $this->notification->toArray());

        $this->notification->delete();
    }

}