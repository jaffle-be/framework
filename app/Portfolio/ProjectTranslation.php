<?php namespace App\Portfolio;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Sluggable\Sluggable;
use App\System\Translatable\TranslationModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ProjectTranslation extends TranslationModel implements Searchable, SluggableInterface
{

    use SearchableTrait, Sluggable, SluggableTrait;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['published', 'title', 'description'];

    protected $hidden = ['project_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

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

}