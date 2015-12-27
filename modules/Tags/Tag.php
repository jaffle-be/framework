<?php

namespace Modules\Tags;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Translatable\Translatable;

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

    public function posts()
    {
        return $this->morphedByMany('Modules\Blog\Post', 'taggable');
    }

    public function projects()
    {
        return $this->morphedByMany('Modules\Portfolio\Project', 'taggable');
    }

    public function content()
    {
        return $this->hasMany('Modules\Tags\TaggedContent');
    }

    public function getCubeportfolioAttribute()
    {
        return 'cube'.str_slug(ucfirst($this->name));
    }

    public function newCollection(array $models = [])
    {
        return new TagCollection($models);
    }
}
