<?php namespace App\Blog;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Tags\Taggable;

class Post extends Model implements StoresMedia{

    use Translatable;
    use Taggable;
    use StoringMedia;

    protected $table = 'posts';

    protected $media = 'blog';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function getPublishedAtAttribute()
    {
        return $this->getAttribute('created_at');
    }
}