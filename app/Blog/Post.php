<?php namespace App\Blog;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\System\Scopes\ModelAccountResource;
use App\Tags\Taggable;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Jaffle\Tools\Sluggable;

class Post extends Model implements StoresMedia
{

    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use Sluggable;

    protected $table = 'posts';

    protected $media = '{account}/blog';

    protected $fillable = ['account_id', 'title', 'extract', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    protected $dates = ['publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new PostCollection($models);
    }

}