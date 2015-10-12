<?php namespace App\Tags;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model implements Searchable
{

    use Translatable;
    use ModelAccountResource;
    use SearchableTrait;

    protected $table = "tags";

    protected $with = 'translations';

    protected $fillable = ['account_id', 'name'];

    protected $translatedAttributes = ['name'];

    public function posts()
    {
        return $this->morphedByMany('App\Blog\Post', 'taggable');
    }

    public function projects()
    {
        return $this->morphedByMany('App\Portfolio\Project', 'taggable');
    }

    public function content()
    {
        return $this->hasMany('App\Tags\TaggedContent');
    }

    public function getCubeportfolioAttribute()
    {
        return 'cube' . str_slug(ucfirst($this->name));
    }

    public function newCollection(array $models = [])
    {
        return new TagCollection($models);
    }

}