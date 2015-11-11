<?php namespace Modules\Marketing\Newsletter;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Translatable\Translatable;

class Campaign extends Model implements StoresMedia
{

    protected $media = '{account}/newsletters';

    use StoringMedia;
    use Translatable;
    use ModelAccountResource;

    protected $table = 'newsletter_campaigns';

    protected $fillable = ['account_id', 'mail_chimp_campaign_id', 'title', 'subject', 'intro', 'use_intro'];

    protected $translatedAttributes = ['mail_chimp_campaign_id', 'title', 'subject', 'intro'];

    protected $hidden = ['mail_chimp_campaign_id', 'title', 'subject', 'intro'];

    protected $casts = [
        'use_intro' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Users\User');
    }

    public function widgets()
    {
        return $this->hasMany('Modules\Marketing\Newsletter\CampaignWidget', 'campaign_id');
    }
}