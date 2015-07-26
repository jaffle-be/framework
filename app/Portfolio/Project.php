<?php namespace App\Portfolio;

use App\Media\StoresMedia;
use App\Tags\Taggable;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model implements StoresMedia
{
    use Translatable;
    use Taggable;

    protected $table = "portfolio_projects";

    protected $fillable = ['client_name', 'website', 'date', 'title', 'description'];

    protected $dates = ['date'];

    protected $translatedAttributes = ['title', 'description'];

    public function getMediaFolder()
    {
        return sprintf('portfolio/%d/', $this->attributes['id']);
    }

    public function images()
    {
        return $this->morphMany('App\Media\Image', 'owner');
    }

    public function collaborators()
    {
        return $this->belongsToMany('App\Users\User', 'portfolio_project_collaborators', 'project_id', 'user_id');
    }

}