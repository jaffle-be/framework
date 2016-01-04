<?php

namespace Modules\Pages;

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
 * Class PageTranslation
 * @package Modules\Pages
 */
class PageTranslation extends TranslationModel implements Searchable, SluggableInterface, OwnsSlug, PresentableEntity, PresentableCache
{
    use SearchableTrait;
    use SiteSluggable;
    use PresentableTrait;
    use FrontScoping;

    protected $table = 'page_translations';

    protected $fillable = ['title', 'content', 'published'];

    protected $presenter = 'Modules\Pages\Presenter\PageFrontPresenter';

    protected $sluggable = [
        'build_from' => 'title',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->page->account;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo('Modules\Pages\Page');
    }

    protected static $searchableMapping = [
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];
}
