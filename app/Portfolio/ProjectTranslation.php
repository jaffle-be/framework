<?php namespace App\Portfolio;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Translatable\TranslationModel;

class ProjectTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['published', 'title', 'description'];

    protected $hidden = ['project_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

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