<?php namespace App\Media;

use App\System\Translatable\TranslationModel;

class ImageTranslation extends TranslationModel{

    protected $table = 'media_image_translations';

    protected $fillable = ['title'];

}