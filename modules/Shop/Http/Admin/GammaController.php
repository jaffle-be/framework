<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Jobs\Gamma\ActivateBrand;
use Modules\Shop\Jobs\Gamma\ActivateCategory;
use Modules\Shop\Jobs\Gamma\DeactivateBrand;
use Modules\Shop\Jobs\Gamma\DeactivateCategory;
use Modules\Shop\Jobs\Gamma\Notification\NotifyDetailActivation;
use Modules\Shop\Jobs\Gamma\Notification\NotifyDetailDeactivation;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\System\Http\AdminController;

class GammaController extends AdminController
{

    public function templateCategories()
    {
        return view('shop::admin.categories.overview');
    }

    public function categories(GammaSelection $gamma, GammaNotification $notification)
    {
        $categories = Category::with(['translations', 'selection', 'brands', 'brands.translations', 'brands.selection'])->get();

        $ids = $categories->lists('id')->toArray();

        if(!count($ids))
        {
            return new Collection();
        }

        $selections = $this->selections($gamma, 'category_id', $ids);

        $reviews = $this->reviews($notification, 'category_id', $ids);

        return $categories->map(function($category) use ($selections, $reviews)
        {
            $category->activated = $category->selection ? true : false;
            $category->selection = null;

            $bSelections = $selections->get($category->id);
            $bReviews = $reviews->get($category->id);

            $category->brands = $category->brands->map(function($brand) use ($bSelections, $bReviews){
                $brand->activated = $brand->selection ? true : false;
                $brand->selection = null;

                $inReview = $bReviews && $bReviews->contains('brand_id', $brand->id);
                $actuallySelected = $bSelections && $bSelections->contains('brand_id', $brand->id);

                $brand->selected = ($actuallySelected && !$inReview) || (!$actuallySelected && $inReview);
                $brand->inReview = $inReview;

                return $brand;
            });

            return $category;
        });
    }

    public function category(Request $request, AccountManager $manager, Category $categories)
    {
        $activate = $request->get('status');
        $category = $categories->findOrFail($request->get('category'));

        if ($activate) {
            $this->dispatch(new ActivateCategory($category, $manager->account()));
        } else {
            $this->dispatch(new DeactivateCategory($category, $manager->account()));
        }
    }

    public function templateBrands()
    {
        return view('shop::admin.brands.overview');
    }

    public function brands(GammaSelection $gamma, GammaNotification $notification)
    {
        $brands = Brand::with(['translations', 'selection', 'categories', 'categories.translations', 'categories.selection'])->get();

        $ids = $brands->lists('id')->toArray();

        if(!count($ids))
        {
            return new Collection();
        }

        $selections = $this->selections($gamma, 'brand_id', $ids);

        $reviews = $this->reviews($notification, 'brand_id', $ids);

        return $brands->map(function($brand) use ($selections, $reviews)
        {
            $brand->activated = $brand->selection ? true : false;
            $brand->selection = null;

            $cSelections = $selections->get($brand->id);
            $cReviews = $reviews->get($brand->id);

            $brand->categories = $brand->categories->map(function($category) use ($cSelections, $cReviews){
                $category->activated = $category->selection ? true : false;
                $category->selection = null;

                $inReview = $cReviews && $cReviews->contains('category_id', $category->id);
                $actuallySelected = $cSelections && $cSelections->contains('category_id', $category->id);

                $category->selected = ($actuallySelected && !$inReview) || (!$actuallySelected && $inReview);
                $category->inReview = $inReview;

                return $category;
            });

            return $brand;
        });
    }

    public function brand(Request $request, AccountManager $manager, Brand $brands)
    {
        $activate = $request->get('status');
        $brand = $brands->findOrFail($request->get('brand'));

        if ($activate) {
            $this->dispatch(new ActivateBrand($brand, $manager->account()));
        } else {
            $this->dispatch(new DeactivateBrand($brand, $manager->account()));
        }
    }

    public function detail(Request $request, Category $category, Brand $brand, AccountManager $manager)
    {
        $status = $request->get('status');
        $brand = $brand->find($request->get('brand'));
        $category = $category->find($request->get('category'));

        if($status)
        {
            $this->dispatch(new NotifyDetailActivation($brand, $category, $manager->account()));
        }
        else{
            $this->dispatch(new NotifyDetailDeactivation($brand, $category, $manager->account()));
        }
    }

    protected function selections(GammaSelection $gamma, $field, $ids)
    {
        $selections = $gamma->whereIn($field, $ids)
            ->get()
            ->groupBy($field);

        return $selections;
    }

    protected function reviews(GammaNotification $notification, $field, $ids)
    {
        $reviews = $notification->whereIn($field, $ids)
            ->get()
            ->groupBy($field);

        return $reviews;
    }

}