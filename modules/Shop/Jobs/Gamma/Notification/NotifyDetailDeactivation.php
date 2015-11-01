<?php namespace Modules\Shop\Jobs\Gamma\Notification;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\BrandSelection;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

class NotifyDetailDeactivation extends Job implements SelfHandling
{

    use GammaNotificationHelpers;

    protected $brand;

    protected $category;

    protected $account;

    public function __construct(Brand $brand, Category $category, Account $account)
    {
        $this->brand = $brand;
        $this->category = $category;
        $this->account = $account;
    }

    public function handle(GammaNotification $notification)
    {
        //did we already have a brand activation notification for this brand?
        //then we simply cancel that it by deleting it.
        //if not, we're allowed to create the record.

        $existing = $this->findExistingCombination($notification, $this->brand, $this->category);

        if ($existing) {
            $existing->delete();
        } else {
            $instance = $notification->newInstance([
                'account_id'            => $this->account->id,
                'category_id'           => $this->category->id,
                'brand_id'              => $this->brand->id,
                'brand_selection_id'    => $this->brand->selection->id,
                'category_selection_id' => $this->category->selection->id,
                'type'                  => BrandSelection::DEACTIVATE,
            ]);

            $instance->save();
        }
    }

}