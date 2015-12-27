<?php

namespace Modules\Account;

use Modules\System\Translatable\TranslationModel;

class RoleTranslation extends TranslationModel
{
    protected $table = 'account_membership_roles_translations';

    protected $fillable = ['name'];
}
