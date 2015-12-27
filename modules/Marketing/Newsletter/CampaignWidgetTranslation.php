<?php

namespace Modules\Marketing\Newsletter;

use Modules\System\Translatable\TranslationModel;

class CampaignWidgetTranslation extends TranslationModel
{

    protected $table = 'newsletter_campaign_widget_translations';

    protected $fillable = ['title', 'text', 'title_left', 'text_left', 'title_right', 'text_right'];

    public function campaignWidget()
    {
        return $this->belongsTo('Modules\Marketing\Newsletter\CampaignWidget', 'widget_id');
    }
}
