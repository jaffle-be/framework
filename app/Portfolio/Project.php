<?php namespace App\Portfolio;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Scopes\FrontScoping;
use App\System\Scopes\ModelAccountResource;
use App\System\Translatable\Translatable;
use App\Tags\StoresTags;
use App\Tags\Taggable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model implements StoresMedia, Searchable, StoresTags, PresentableEntity
{
    use Translatable;
    use PresentableTrait;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;
    use SearchableTrait;
    use FrontScoping;

    protected $table = "portfolio_projects";

    protected $media = '{account}/portfolio';

    protected $fillable = ['account_id', 'client_id', 'website', 'date', 'published', 'title', 'content'];

    protected $dates = ['date'];

    protected $translatedAttributes = ['published', 'title', 'content'];

    protected $presenter = 'App\Portfolio\Presenter\ProjectFrontPresenter';

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