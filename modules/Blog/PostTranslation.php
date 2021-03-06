<?php

namespace Modules\Blog;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableCache;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Sluggable\SiteSluggable;
use Modules\System\Translatable\TranslationModel;

/**
 * Class PostTranslation
 * @package Modules\Blog
 */
class PostTranslation extends TranslationModel implements Searchable, SluggableInterface, OwnsSlug, PresentableEntity, PresentableCache
{
    use SearchableTrait;
    use SiteSluggable;
    use PresentableTrait;
    use FrontScoping;

    protected $table = 'post_translations';

    protected $fillable = ['title', 'content', 'publish_at'];

    protected $presenter = 'Modules\Blog\Presenter\PostFrontPresenter';

    protected $sluggable = [
        'build_from' => 'title',
    ];

    protected $dates = ['publish_at'];

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->post->account;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Modules\Blog\Post');
    }

    protected static $searchableMapping = [
        'publish_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd',
        ],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        if (isset($data['publish_at']) && $data['publish_at']) {
            $data['publish_at'] = $this->publish_at->format('Y-m-d');
        }

        return $data;
    }

    /**
     * @param $query
     * @param null $locale
     */
    public function scopeLastPublished($query, $locale = null)
    {
        if (empty($locale)) {
            $locale = app()->getLocale();
        }

        $query->where('locale', $locale)->orderBy('publish_at');
    }
}
