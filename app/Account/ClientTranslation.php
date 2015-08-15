<?php namespace App\Account;

use Jaffle\Tools\TranslationModel;

class ClientTranslation extends TranslationModel
{

    protected $table = 'account_clients_translations';

    protected $fillable = ['description'];

}