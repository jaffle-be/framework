<?php namespace App\Blog;

use App\Media\StoresMedia;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Tags\Taggable;

class Post extends Model implements StoresMedia{

    use Translatable;
    use Taggable;

    protected $table = 'posts';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function images()
    {
        return $this->morphMany('App\Media\Image', 'owner');
    }

    public function getMediaFolder()
    {
        return sprintf('blog/%d/', $this->attributes['id']);
    }

    public function getPublishedAtAttribute()
    {
        return $this->getAttribute('created_at');
    }
}