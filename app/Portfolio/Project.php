<?php namespace App\Portfolio;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use App\System\Scopes\ModelAccountResource;
use App\Tags\Taggable;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model implements StoresMedia
{
    use Translatable;
    use Taggable;
    use StoringMedia;
    use ModelAccountResource;

    protected $table = "portfolio_projects";

    protected $media = 'portfolio';

    protected $fillable = ['account_id', 'client_name', 'website', 'date', 'title', 'description'];

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

}