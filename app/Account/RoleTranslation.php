<?php namespace App\Account;

use Jaffle\Tools\TranslationModel;

class RoleTranslation extends TranslationModel
{

    protected $table = 'account_membership_roles_translations';

    protected $fillable = ['name'];

}