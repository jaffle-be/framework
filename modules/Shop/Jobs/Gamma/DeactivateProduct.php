<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

class DeactivateProduct extends Job implements SelfHandling
{
    protected $product;

    protected $categorie;

    protected $account;

    public function __construct(Product $product, Category $category, Account $account)
    {
        $this->product = $product;
        $this->category = $category;
        $this->account = $account;
    }

    public function handle(ProductSelection $selection)
    {
        //when no record exists, insert and delete (or do it manually)
        //when a record exists trash it.
        $payload = [
            'account_id'  => $this->account->id,
            'product_id'  => $this->product->id,
            'brand_id'    => $this->product->brand_id,
        ];

        $record = $selection->newQuery()->where($payload)->first();

        if(!$record)
        {
            $record = $selection->create($payload);

            $category = $this->attachCategory($record);
        }
        else{
            $category_id = $this->category->id;

            $record->load(['categories' => function($query) use ($category_id){
                $query->where('category_id', $category_id);
                $query->withTrashed();
            }]);

            $category = $record->categories->first();

            if(!$category)
            {
                $category = $this->attachCategory($record);
            }
        }

        //set them as deactivated.
        $category->delete();

        //only delete the base record when no more active categories are left.
        if($record->categories()->count() == 0)
        {
            $record->delete();
        }
    }

    /**
     * @param $record
     *
     * @return ProductCategorySelection
     */
    protected function attachCategory($record)
    {
        $category = new ProductCategorySelection(['category_id' => $this->category->id]);

        $record->categories()->save($category);

        return $category;
    }
}