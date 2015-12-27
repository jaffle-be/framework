<?php

namespace Modules\Marketing\Http\Admin;

use Illuminate\Http\Request;
use Modules\Marketing\Newsletter\Campaign;
use Modules\Marketing\Newsletter\CampaignWidget;
use Modules\Marketing\Newsletter\CampaignWidgetCollection;
use Modules\System\Http\AdminController;

/**
 * Class NewsletterWidgetController
 * @package Modules\Marketing\Http\Admin
 */
class NewsletterWidgetController extends AdminController
{
    /**
     * @param Campaign $campaign
     * @param Request $request
     * @return CampaignWidget|void
     */
    public function store(Campaign $campaign, Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $widget = new CampaignWidget([
            'campaign_id' => $campaign->id,
            'path' => $request->get('name'),
            'manual' => false,
        ]);

        return $widget->save() ? $widget : abort(500);
    }

    /**
     * @param Campaign $campaign
     * @param CampaignWidget $widget
     * @param Request $request
     * @return mixed
     */
    public function update(Campaign $campaign, CampaignWidget $widget, Request $request)
    {
        if ($campaign->widgets->contains($widget->id)) {
            $widget->fill(translation_input($request));

            $widget->save();

            $widget->load(['resource', 'otherResource']);

            //this is a hack to load the extra resources onto the widget.
            $widgets = new CampaignWidgetCollection([$widget]);

            $widgets = $widgets->toArray();

            return array_pop($widgets);
        }
    }

    /**
     * @param Campaign $campaign
     * @param CampaignWidget $widget
     * @param Request $request
     * @return CampaignWidget
     * @throws \Exception
     */
    public function destroy(Campaign $campaign, CampaignWidget $widget, Request $request)
    {
        if ($campaign->widgets->contains($widget->id)) {
            if ($widget->delete()) {
                $widget->id = false;
            }
        }

        return $widget;
    }
}
