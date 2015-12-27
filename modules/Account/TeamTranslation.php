<?php

namespace Modules\Account;

use Modules\System\Translatable\TranslationModel;

/**
 * Class TeamTranslation
 * @package Modules\Account
 */
class TeamTranslation extends TranslationModel
{
    protected $table = 'account_teams_translations';

    protected $fillable = ['name', 'description'];
}
