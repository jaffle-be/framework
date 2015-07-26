<?php namespace App\Portfolio;

use Jaffle\Tools\TranslationModel;

class ProjectTranslation extends TranslationModel
{

    protected $table = 'portfolio_project_translations';

    protected $fillable = ['title', 'description'];

}