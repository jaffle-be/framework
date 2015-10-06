<?php namespace App\Media\Video;

use App\System\Translatable\TranslationModel;

class VideoTranslation extends TranslationModel
{

    protected $table = 'media_video_translations';

    protected $fillable = ['title'];

}