<?php

namespace Modules\Portfolio;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableCache;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

/**
 * Class ProjectTranslation
 * @package Modules\Portfolio
 */
class ProjectTranslation extends TranslationModel implements Searchable, SluggableInterface, PresentableEntity, PresentableCache
{
    use SearchableTrait;
    use Sluggable;
    use PresentableTrait;
    use FrontScoping;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['published', 'title', 'content'];

    protected $hidden = ['project_id'];

    protected $casts = [
        'published' => 'boolean',
    ];

    protected $presenter = 'Modules\Portfolio\Presenter\ProjectFrontPresenter';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('Modules\Portfolio\Project');
    }
}
