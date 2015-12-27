<?php

namespace Modules\Tags;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Translatable\Translatable;

/**
 * Class Tag
 * @package Modules\Tags
 */
class Tag extends Model implements Searchable
{
    use Translatable;
    use ModelAccountResource;
    use SearchableTrait;

    protected $table = 'tags';

    protected $with = 'translations';

    protected $fillable = ['account_id', 'name'];

    protected $translatedAttributes = ['name'];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'account_id' => ['type' => 'integer'],
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function posts()
    {
        return $this->morphedByMany('Modules\Blog\Post', 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function projects()
    {
        return $this->morphedByMany('Modules\Portfolio\Project', 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function content()
    {
        return $this->hasMany('Modules\Tags\TaggedContent');
    }

    /**
     * @return string
     */
    public function getCubeportfolioAttribute()
    {
        return 'cube'.str_slug(ucfirst($this->name));
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new TagCollection($models);
    }
}
