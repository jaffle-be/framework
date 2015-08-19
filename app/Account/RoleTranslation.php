<?php namespace App\Account;

use App\System\Translatable\TranslationModel;

class RoleTranslation extends TranslationModel
{

    protected $table = 'account_membership_roles_translations';

    protected $fillable = ['name'];

}