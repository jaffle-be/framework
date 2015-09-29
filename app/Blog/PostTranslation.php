<?php namespace App\Blog;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Translatable\TranslationModel;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use App\System\Sluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Http\Request;

class PostTranslation extends TranslationModel implements Searchable, SluggableInterface
{

    use SearchableTrait, SluggableTrait, Sluggable;

    protected $table = 'post_translations';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $dates = ['publish_at'];

    protected $touches = ['post'];

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