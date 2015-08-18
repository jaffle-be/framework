<?php namespace App\Blog;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Scopes\ModelAccountResource;
use App\Tags\Taggable;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Jaffle\Tools\Sluggable;

class Post extends Model implements StoresMedia, Searchable
{

    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use Sluggable;
    use SearchableTrait;

    protected $table = 'posts';

    protected $media = '{account}/blog';

    protected $fillable = ['account_id', 'title', 'extract', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    protected $hidden = ['title', 'extract', 'content', 'publish_at'];

    protected $dates = ['publish_at'];

    protected static $searchableMapping = [
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'publish_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd'
        ],
    ];

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