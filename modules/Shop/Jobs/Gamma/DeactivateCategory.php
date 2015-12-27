<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Category;

/**
 * Class DeactivateCategory
 * @package Modules\Shop\Jobs\Gamma
 */
class DeactivateCategory extends Job
{
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
     * @param GammaNotification $notifications
     */
    public function handle(GammaNotification $notifications)
    {
        $processingOrExisting = $notifications->where('category_id', $this->category->id)
            ->count();

        if ($processingOrExisting) {
            $message = "can't deactivate, something is still being processed";
            abort(400, $message, ['statustext' => $message]);
        }

        if ($this->category->selection) {
            $this->category->selection->delete();
        }
    }
}
