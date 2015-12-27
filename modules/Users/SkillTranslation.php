<?php

namespace Modules\Users;

use Modules\System\Translatable\TranslationModel;

class SkillTranslation extends TranslationModel
{
    protected $table = 'user_skills_translations';

    protected $fillable = ['name', 'description'];
}
