<?php

namespace Modules\Users;

use Modules\System\Translatable\TranslationModel;

/**
 * Class SkillTranslation
 * @package Modules\Users
 */
class SkillTranslation extends TranslationModel
{
    protected $table = 'user_skills_translations';

    protected $fillable = ['name', 'description'];
}
