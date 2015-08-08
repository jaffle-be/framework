<?php namespace App\Users;

use Jaffle\Tools\TranslationModel;

class SkillTranslation extends TranslationModel
{

    protected $table = 'user_skills_translations';

    protected $fillable = ['name', 'description'];

}