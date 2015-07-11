<?php namespace App\Media;

use Jaffle\Tools\TranslationModel;

class ImageTranslation extends TranslationModel{

    protected $table = 'media_image_translations';

    protected $fillable = ['title'];

}