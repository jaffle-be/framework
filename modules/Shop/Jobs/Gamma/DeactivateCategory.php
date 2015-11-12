<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
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

    public function handle(GammaNotification $notifications)
    {
        $processingOrExisting = $notifications->where('category_id', $this->category->id)
            ->count();

        if($processingOrExisting)
        {
            $message = "can't deactivate, something is still being processed";
            abort(400, $message, ['statustext' => $message]);
        }

        if($this->category->selection)
        {
            $this->category->selection->delete();
        }
    }
}