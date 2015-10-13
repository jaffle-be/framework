<?php namespace App\Portfolio;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Sluggable\Sluggable;
use App\System\Translatable\TranslationModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ProjectTranslation extends TranslationModel implements Searchable, SluggableInterface, PresentableEntity
{

    use SearchableTrait, Sluggable, SluggableTrait, PresentableTrait;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['published', 'title', 'description'];

    protected $hidden = ['project_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $presenter = 'App\Portfolio\Presenter\ProjectFrontPresenter';

    public function project()
    {
        return $this->belongsTo('App\Portfolio\Project');
    }

    public static function bootProjectTranslationScopeFront()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new ProjectTranslationScopeFront());
        }
    }


    public function toArray()
    {
        $data = parent::toArray();

        $request = app('request');

        if(starts_with($request->getRequestUri(), '/api'))
        {
            $data['extract'] = $this->present()->extract;
        }

        return $data;
    }

}