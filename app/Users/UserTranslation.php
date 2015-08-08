<?php namespace App\Users;

use Jaffle\Tools\TranslationModel;

class UserTranslation extends TranslationModel
{

    protected $table = 'user_profile_translations';

    protected $fillable = ['bio', 'quote', 'quote_author'];

}