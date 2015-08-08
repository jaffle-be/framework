<?php namespace App\Account;

use Jaffle\Tools\TranslationModel;

class TeamTranslation extends TranslationModel
{
    protected $table = 'account_teams_translations';

    protected $fillable = ['name'];

}