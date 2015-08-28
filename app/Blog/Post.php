<?php namespace App\Blog;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Sluggable\Sluggable;
use App\System\Translatable\Translatable;
use App\Tags\StoresTags;
use App\Tags\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model implements StoresMedia, Searchable, StoresTags
{

    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use Sluggable;
    use SearchableTrait;

    public static function bootPostFrontScope()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new PostFrontScope());
        }
    }

    protected $table = 'posts';

    protected $media = '{account}/blog';

    protected $fillable = ['account_id', 'title', 'extract', 'content', 'publish_at', 'slug_nl', 'slug_fr', 'slug_en', 'slug_de'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    protected $hidden = ['title', 'extract', 'content', 'publish_at'];

    protected static $searchableMapping = [
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
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