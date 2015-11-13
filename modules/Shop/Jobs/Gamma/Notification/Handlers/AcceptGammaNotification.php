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
        $type = $this->notification->type;

        switch ($type) {
            case 'activate':

                if ($this->notification->product) {
                    $this->dispatch(new ActivateProduct($this->notification->product, $this->notification->category, $this->notification->account));
                } else {
                    $this->activate($catalog, $gamma);
                }

                break;
            case 'deactivate':
                if ($this->notification->product) {
                    $this->dispatch(new DeactivateProduct($this->notification->product, $this->notification->category, $this->notification->account));
                } else {
                    $this->deactivate($gamma, $productGamma);
                }

                //when we deactivated something, we can check if everything is deactivated, if so.. we should also deactivate the selection
                //so our product selections table is as small as possible.
                if ($productGamma->countActiveProducts($this->notification->brand_id, $this->notification->category_id) == 0) {
                    $this->dispatch(new CleanupDetail($this->notification->brand, $this->notification->category, $this->notification->account));
                };

                break;
            default:
                throw new \InvalidArgumentException('Unknown type trying to handle gamma notification');
        }

        $pusher->trigger(pusher_account_channel(), 'gamma.gamma_notification.confirmed', $this->notification->toArray());

        $this->notification->delete();
    }

    protected function activate(CatalogRepositoryInterface $catalog, GammaSelection $gamma)
    {
        $notification = $this->notification;

        $this->insertGamma($gamma);

        $catalog->chunkWithinBrandCategory($notification->brand, $notification->category, function ($products) use ($notification) {
            foreach ($products as $product) {
                $this->dispatch(new ActivateProduct($product, $notification->category, $notification->account));
            }
        });
    }

    protected function deactivate(GammaSelection $gamma, ProductSelection $productGamma)
    {
        $brand = $this->notification->brand->id;
        $category = $this->notification->category->id;

        while ($productGamma->countActiveProducts($brand, $category) > 0) {

            $selections = $productGamma->where('brand_id', $brand)
                ->where('category_id', $category)
                ->take(200)->get();

            foreach ($selections as $selection) {
                $selection->delete();
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

}