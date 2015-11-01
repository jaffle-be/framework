<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Product\CatalogRepositoryInterface;

class AcceptGammaNotification extends Job implements SelfHandling
{

    use DispatchesJobs;

    protected $notification;

    public function __construct(GammaNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle(CatalogRepositoryInterface $catalog, GammaSelection $gamma, ProductSelection $productGamma)
    {
        $type = $this->notification->type;

        switch ($type) {
            case 'activate':
                $this->activate($catalog, $gamma, $productGamma);
                break;
            case 'deactivate':
                $this->deactivate($gamma, $productGamma);
                break;
            default:
                throw new \InvalidArgumentException('Unknown type trying to handle gamma notification');
        }

        $this->notification->delete();
    }

    protected function activate(CatalogRepositoryInterface $catalog, GammaSelection $gamma, ProductSelection $productGamma)
    {
        $notification = $this->notification;

        $this->insertGamma($gamma);

        $me = $this;

        $catalog->chunkWithinBrandCategory($notification->brand, $notification->category, function ($products) use ($notification, $productGamma) {
            $ids = $products->lists('id')->toArray();

            $existing = $productGamma->whereIn('product_id', $ids)->distinct()->lists('product_id');

            foreach ($products as $product) {
                if ($existing->search($product->id) === false) {
                    $this->dispatch(new ActivateProduct($product, $notification->category, $notification->account));
                }
            }
        });
    }

    protected function deactivate(GammaSelection $gamma, ProductSelection $productGamma)
    {
        $brand = $this->notification->brand->id;
        $category = $this->notification->category->id;

        while ($this->countActiveProducts($productGamma, $brand, $category) > 0) {

            $selections = $productGamma->where('brand_id', $brand)
                ->where('category_id', $category)
                ->take(200)->get();

            foreach ($selections as $selection) {
                $selection->delete();
            }
        }

        $this->deleteGamma($gamma);
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

    protected function countActiveProducts(ProductSelection $productGamma, $brand, $category)
    {
        return $productGamma->where('brand_id', $brand)
            ->where('category_id', $category)
            ->count();
    }

    protected function deleteGamma(GammaSelection $gamma)
    {
        $gamma->where('category_id', $this->notification->category->id)
            ->where('brand_id', $this->notification->brand->id)
            ->delete();
    }

}