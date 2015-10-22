<?php namespace App\Media\Video;

use App\System\Scopes\ModelAccountResource;
use App\System\Scopes\ModelAutoSort;
use App\System\Scopes\ModelLocaleSpecificResource;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use ModelAccountResource;
    use ModelAutoSort;
    use ModelLocaleSpecificResource;

    protected $table = 'media_videos';

    protected $fillable = ['account_id', 'locale_id', 'title', 'description', 'provider', 'provider_id', 'provider_thumbnail', 'width', 'height'];

    public function getEmbedAttribute()
    {
        if($this->provider == 'youtube')
        {
            $format = '<iframe width="%d" height="%d" src="https://www.youtube.com/embed/%s" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
        elseif($this->provider == 'vimeo')
        {
            $format = '<iframe width="%d" height="%d" src="//player.vimeo.com/video/%d" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }

        if(isset($format))
        {
            return sprintf($format,  $this->attributes['width'], $this->attributes['height'], $this->attributes['provider_id']);
        }
    }

    public function owner()
    {
        return $this->morphTo();
    }
}