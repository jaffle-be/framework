<?php

namespace Modules\Marketing\Newsletter;

use Modules\System\Translatable\TranslationModel;

/**
 * Class CampaignWidgetTranslation
 * @package Modules\Marketing\Newsletter
 */
class CampaignWidgetTranslation extends TranslationModel
{
    protected $table = 'newsletter_campaign_widget_translations';

    protected $fillable = ['title', 'text', 'title_left', 'text_left', 'title_right', 'text_right'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaignWidget()
    {
        return $this->belongsTo('Modules\Marketing\Newsletter\CampaignWidget', 'widget_id');
    }
}
