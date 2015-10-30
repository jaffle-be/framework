<?php namespace Modules\Shop\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Shop\Jobs\Gamma\ActivateBrand;
use Modules\Shop\Jobs\Gamma\ActivateCategory;
use Modules\Shop\Jobs\Gamma\DeactivateBrand;
use Modules\Shop\Jobs\Gamma\DeactivateCategory;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\System\Http\AdminController;

class GammaController extends AdminController
{

    public function templateCategories()
    {
        return view('shop::admin.categories.overview');
    }

    public function categories()
    {
        $categories = Category::with(['translations', 'selection'])->get();

        return $categories->map(function($item)
        {
            $item->activated = $item->selection ? true : false;
            $item->selection = null;

            return $item;
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

    public function brands()
    {
        $brands = Brand::with(['translations', 'selection'])->get();

        return $brands->map(function($item)
        {
            $item->activated = $item->selection ? true : false;
            $item->selection = null;

            return $item;
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

}