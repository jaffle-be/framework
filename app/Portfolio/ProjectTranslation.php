<?php namespace App\Portfolio;

use App\Search\Model\Searchable;
use App\Search\Model\SearchableTrait;
use App\System\Translatable\TranslationModel;

class ProjectTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['title', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'project_id'];

}