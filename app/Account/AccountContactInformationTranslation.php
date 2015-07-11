<?php

namespace App\Account;

use Jaffle\Tools\TranslationModel;

class AccountContactInformationTranslation extends TranslationModel{

    protected $table = "account_contact_information_translations";

    protected $fillable = ["description", "widget"];

}