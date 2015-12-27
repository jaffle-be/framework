<?php

namespace Modules\Account;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ClientTranslation
 * @package Modules\Account
 */
class ClientTranslation extends TranslationModel
{
    protected $table = 'account_clients_translations';

    protected $fillable = ['description'];
}
