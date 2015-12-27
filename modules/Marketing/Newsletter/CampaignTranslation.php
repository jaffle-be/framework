<?php

namespace Modules\Marketing\Newsletter;

use Modules\System\Translatable\TranslationModel;

class CampaignTranslation extends TranslationModel
{
    protected $table = 'newsletter_campaign_translations';

    protected $fillable = ['title', 'subject', 'intro'];

    public function getAccount()
    {
        return $this->campaign->account;
    }

    public function campaign()
    {
        return $this->belongsTo('Modules\Marketing\Newsletter\Campaign');
    }
}
