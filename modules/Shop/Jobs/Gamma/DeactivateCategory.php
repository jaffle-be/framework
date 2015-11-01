<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\CategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Category;

class DeactivateCategory extends Job implements SelfHandling
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Category $category, Account $account)
    {
        $this->category = $category;
        $this->account = $account;
    }

    public function handle()
    {
        if($this->category->selection)
        {
            $this->category->selection->delete();
        }
    }
}