<?php

namespace Modules\Account;

use Modules\System\Translatable\TranslationModel;

/**
 * Class RoleTranslation
 * @package Modules\Account
 */
class RoleTranslation extends TranslationModel
{
    protected $table = 'account_membership_roles_translations';

    protected $fillable = ['name'];
}
