<?php namespace App\Blog;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Sluggable\OwnsSlug;
use App\System\Sluggable\SiteSluggable;
use App\System\Translatable\TranslationModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Http\Request;

class PostTranslation extends TranslationModel implements Searchable, SluggableInterface, OwnsSlug, PresentableEntity
{
    use SearchableTrait, SiteSluggable, PresentableTrait;

    protected $table = 'post_translations';

    protected $fillable = ['title', 'content', 'publish_at'];

    protected $presenter = 'App\Blog\Presenter\PostFrontPresenter';

    protected $sluggable = [
        'build_from' => 'title',
    ];

    protected $dates = ['publish_at'];

    protected $touches = ['post'];

    public function getAccount()
    {
        return $this->post->account;
    }

    public static function bootPostTranslationScopeFront()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new PostTranslationScopeFront());
        }
    }

    public function post()
    {
        return $this->belongsTo('App\Blog\Post');
    }

    protected static $searchableMapping = [
        'publish_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd'
        ],
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ];

    public function toArray()
    {
        $data = parent::toArray();

        if(isset($data['publish_at']) && $data['publish_at'])
        {
            $data['publish_at'] = $this->publish_at->format('Y-m-d');
        }

        $request = app('request');

        if(starts_with($request->getRequestUri(), '/api'))
        {
            $data['extract'] = $this->present()->extract;
        }

        return $data;
    }

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function scopeLastPublished($query, $locale = null)
    {
        if (empty($locale)) {
            $locale = app()->getLocale();
        }

        $query->where('locale', $locale)->orderBy('publish_at');
    }
}