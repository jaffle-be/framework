<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\CategorySelection;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Category;

class NotifyCategoryDeactivation extends Job implements SelfHandling
{

    use GammaNotificationHelpers;

    /**
     * @var
     */
    protected $account;

    /**
     * @var
     */
    protected $category;

    public function __construct(Category $category, Account $account)
    {
        $this->account = $account;
        $this->category = $category;
    }

    public function handle(GammaNotification $notification)
    {
        $this->category->selection->delete();

        foreach ($this->category->brands as $brand) {

            $existing = $this->findExistingCombination($notification, $brand, $this->category);

            if ($existing) {
                $existing->delete();
            } else {
                $instance = $notification->newInstance([
                    'account_id'  => $this->account->id,
                    'category_id' => $this->category->id,
                    'brand_id'    => $brand->id,
                    'type'        => CategorySelection::DEACTIVATE,
                ]);

                $instance->save();
            }
        }
    }

    /**
     * @param GammaNotification $notification
     * @param                   $brand
     * @param                   $category
     *
     * @return mixed
     */
    protected function findExistingCombination(GammaNotification $notification, $brand, $category)
    {
        $existing = $notification
            ->whereHas('brandSelection', function ($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })
            ->whereHas('categorySelection', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->first();

        return $existing;
    }

}