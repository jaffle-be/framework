<?php

namespace Modules\Marketing\Providers;

use Drewm\MailChimp;
use Modules\Marketing\Newsletter\CampaignWidget;
use Modules\System\ServiceProvider;

/**
 * Class MarketingServiceProvider
 * @package Modules\Marketing\Providers
 */
class MarketingServiceProvider extends ServiceProvider
{
    protected $namespace = 'marketing';

    public function register()
    {
        $this->app->singleton(MailChimp::class, function () {
            return new MailChimp(env('MAILCHIMP_APIKEY'));
        });
    }

    protected function listeners()
    {
        $this->app->booted(function () {

            CampaignWidget::saving(function ($item) {

                if ($item->sort === null) {
                    $item->sort = CampaignWidget::where('campaign_id', $item->campaign_id)->count();
                }
            });

            CampaignWidget::deleted(function ($item) {
                CampaignWidget::where('campaign_id', $item->campaign_id)
                    ->where('sort', '>', $item->sort)
                    ->update([
                        'sort' => \DB::raw('sort - 1'),
                    ]);
            });
        });
    }
}
