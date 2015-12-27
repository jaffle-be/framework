<?php

namespace Modules\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Seo\SeoEntity;
use Modules\System\Seo\SeoTrait;
use Modules\System\Translatable\Translatable;
use Modules\Tags\StoresTags;
use Modules\Tags\Taggable;

class Project extends Model implements StoresMedia, Searchable, StoresTags, PresentableEntity, SeoEntity
{
    use Translatable;
    use PresentableTrait;
    use Taggable;
    use StoringMedia;
    use SeoTrait;
    use ModelAccountResource;
    use SearchableTrait;
    use FrontScoping;

    protected $table = 'portfolio_projects';

    protected $media = '{account}/portfolio';

    protected $fillable = ['account_id', 'client_id', 'website', 'date', 'published', 'title', 'content'];

    protected $dates = ['date'];

    protected $translatedAttributes = ['published', 'title', 'content'];

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

    public function newCollection(array $models = [])
    {
        return new ProjectCollection($models);
    }

    public function collaborators()
    {
        return $this->belongsToMany('Modules\Users\User', 'portfolio_project_collaborators', 'project_id', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo('Modules\Account\Client', 'client_id');
    }

    public function toArray()
    {
        $data = parent::toArray();

        if (isset($data['date']) && $data['date']) {
            $data['date'] = $this->date->format('Y-m-d');
        }

        return $data;
    }

    /**
     * Return the type this model uses in Elasticsearch.
     *
     *
     */
    public function getSearchableType()
    {
        return 'projects';
    }
}
