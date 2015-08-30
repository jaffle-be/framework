<?php namespace App\Portfolio;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Scopes\ModelAccountResource;
use App\Tags\StoresTags;
use App\Tags\Taggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model implements StoresMedia, Searchable, StoresTags
{
    use \App\System\Translatable\Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;

    protected $table = "portfolio_projects";

    protected $media = '{account}/portfolio';

    protected $fillable = ['account_id', 'client_id', 'website', 'date', 'published', 'title', 'description'];

    protected $dates = ['date'];

    protected $translatedAttributes = ['published', 'title', 'description'];

    public static function bootProjectScopeFront()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new ProjectScopeFront());
        }
    }

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

    public function toArray()
    {
        $data = parent::toArray();

        if(isset($data['date']) && $data['date'])
        {
            $data['date'] = $this->date->format('Y-m-d');
        }

        return $data;
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