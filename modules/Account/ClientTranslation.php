<?php

namespace Modules\Account;

use Modules\System\Translatable\TranslationModel;

class ClientTranslation extends TranslationModel
{

    protected $table = 'account_clients_translations';

    protected $fillable = ['description'];
}
