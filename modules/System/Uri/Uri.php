<?php namespace Modules\System\Uri;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelLocaleSpecificResource;
use Modules\System\Sluggable\Sluggable;

class Uri extends Model
{

    use Sluggable;
    use ModelLocaleSpecificResource;

    protected $table = 'uris';

    protected $fillable = ['account_id', 'canonical_id', 'locale_id', 'uri', 'owner_type', 'owner_id'];

    protected $sluggable = [
        'build_from' => 'owner.title',
        'save_to'    => 'uri',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

}