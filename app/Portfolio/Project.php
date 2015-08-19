<?php namespace App\Portfolio;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Scopes\ModelAccountResource;
use App\Tags\Taggable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model implements StoresMedia, Searchable
{
    use \App\System\Translatable\Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;

    protected $table = "portfolio_projects";

    protected $media = '{account}/portfolio';

    protected $fillable = ['account_id', 'client_id', 'website', 'date', 'title', 'description'];

    protected $dates = ['date'];

    protected $translatedAttributes = ['title', 'description'];

    public function newCollection(array $models = [])
    {
        return new ProjectCollection($models);
    }

    public function collaborators()
    {
        return $this->belongsToMany('App\Users\User', 'portfolio_project_collaborators', 'project_id', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Account\Client', 'client_id');
    }

    /**
     * Return the type this model uses in Elasticsearch.
     *
     * @return mixed
     */
    public function getSearchableType()
    {
        return 'projects';
    }

}