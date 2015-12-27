<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Gamma\CategorySelection;
use Modules\Shop\Product\Category;

/**
 * Class ActivateCategory
 * @package Modules\Shop\Jobs\Gamma
 */
class ActivateCategory extends Job
{
    use DispatchesJobs;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @param Category $category
     * @param Account $account
     */
    public function __construct(Category $category, Account $account)
    {
        $this->category = $category;
        $this->account = $account;
    }

    /**
     * @param CategorySelection $selection
     */
    public function handle(CategorySelection $selection)
    {
        $instance = $selection->newInstance(['account_id' => $this->account->id]);

        //create selection
        $this->category->selection()->save($instance);
    }
}
