<?php namespace App\Users;

use App\System\Translatable\TranslationModel;

class SkillTranslation extends TranslationModel
{

    protected $table = 'user_skills_translations';

    protected $fillable = ['name', 'description'];

}