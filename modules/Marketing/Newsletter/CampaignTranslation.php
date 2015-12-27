<?php

namespace Modules\Marketing\Newsletter;

use Modules\System\Translatable\TranslationModel;

/**
 * Class CampaignTranslation
 * @package Modules\Marketing\Newsletter
 */
class CampaignTranslation extends TranslationModel
{
    protected $table = 'newsletter_campaign_translations';

    protected $fillable = ['title', 'subject', 'intro'];

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->campaign->account;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('Modules\Marketing\Newsletter\Campaign');
    }
}
