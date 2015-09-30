<?php namespace App\Blog;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Sluggable\Sluggable;
use App\System\Translatable\Translatable;
use App\Tags\StoresTags;
use App\Tags\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model implements StoresMedia, Searchable, StoresTags, PresentableEntity
{

    use PresentableTrait;
    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;

    public static function bootPostScopeFront()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new PostScopeFront());
        }
    }

    protected $table = 'posts';

    protected $media = '{account}/blog';

    protected $fillable = ['account_id', 'title', 'extract', 'content', 'publish_at'];

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    protected $hidden = ['title', 'extract', 'content', 'publish_at'];

    protected $presenter = 'App\Blog\Presenter\PostFrontPresenter';

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

    public function scopeLatest(Builder $builder)
    {
        $builder->leftJoin('post_translations as latest', function($join){
            $join->on('posts.id', '=', 'latest.post_id')
                ->where('latest.locale', '=', app()->getLocale());
        })
            ->orderBy('latest.publish_at');
    }

    public function scopeRelated(Builder $builder)
    {

    }

}