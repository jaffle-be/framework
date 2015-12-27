<?php

namespace Modules\Marketing\Newsletter;

/**
 * Class CampaignBuilder
 * @package Modules\Marketing\Newsletter
 */
class CampaignBuilder
{
    protected $widgets = [

        ['name' => 'regular/2col', 'items' => 2],
        ['name' => 'regular/full', 'items' => 1],
        ['name' => 'regular/img-left', 'items' => 1],
        ['name' => 'regular/img-right', 'items' => 1],
        ['name' => 'complex/2col', 'items' => 2],
        ['name' => 'complex/full', 'items' => 1],
        ['name' => 'complex/img-left', 'items' => 1],
        ['name' => 'complex/img-right', 'items' => 1],
        ['name' => 'text-only/2col', 'items' => 2],
        ['name' => 'text-only/2col-bg', 'items' => 2],
        ['name' => 'text-only/full', 'items' => 1],
        ['name' => 'text-only/full-bg', 'items' => 1],
        ['name' => 'img-only/2col', 'items' => 2],
        ['name' => 'img-only/full', 'items' => 1],
    ];

    /**
     * @param Campaign $campaign
     * @param $locale
     * @return string
     */
    public function build(Campaign $campaign, $locale)
    {
        //it's simple, just load all the shit! :-)

        $campaign->load([
            'translations',
            'widgets',
            'widgets.translations',
            'widgets.resource',
            'widgets.otherResource',
            'widgets.image',
            'widgets.imageLeft',
            'widgets.imageRight',
        ]);

        $campaign->widgets->setData();

        $translation = $campaign->translate($locale);

        return view('marketing::newsletter.campaign', [
            'translation' => $translation,
            'campaign' => $campaign,
            'locale' => $locale,
        ])->render();
    }

    /**
     * @return array
     */
    public function getAvailableWidgets()
    {
        return $this->widgets;
    }
}
