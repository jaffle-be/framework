<?php namespace Modules\Portfolio;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Sluggable\Sluggable;
use Modules\System\Translatable\TranslationModel;

class ProjectTranslation extends TranslationModel implements Searchable, SluggableInterface, PresentableEntity
{

    use SearchableTrait, Sluggable, PresentableTrait, FrontScoping;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['published', 'title', 'content'];

    protected $hidden = ['project_id'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $presenter = 'Modules\Portfolio\Presenter\ProjectFrontPresenter';

    public function project()
    {
        return $this->belongsTo('Modules\Portfolio\Project');
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