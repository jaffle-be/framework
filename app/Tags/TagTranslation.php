<?php namespace App\Tags;

use Jaffle\Tools\TranslationModel;

class TagTranslation extends TranslationModel{

    protected $table = 'tag_translations';

    protected $fillable = ['name'];

}