<?php namespace App\System;

use App\System\Translatable\TranslationModel;

class LocaleTranslation extends TranslationModel
{

    protected $table = "locales_translations";

    protected $fillable = ['name'];

    public $timestamps = false;

}