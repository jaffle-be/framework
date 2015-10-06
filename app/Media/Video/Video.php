<?php namespace App\Media\Video;

use App\System\Scopes\ModelAccountResource;
use App\System\Scopes\ModelAutoSort;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Translatable;
    use ModelAccountResource;
    use ModelAutoSort;

    protected $table = 'media_videos';

    protected $fillable = ['account_id', 'title', 'provider', 'provider_id', 'provider_thumbnail', 'width', 'height'];

    protected $translatedAttributes = ['title'];

    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public function owner()
    {
        return $this->morphTo();
    }
}