<?php

namespace Modules\Media\Video;

use Modules\System\Translatable\TranslationModel;

class VideoTranslation extends TranslationModel
{

    protected $table = 'media_video_translations';

    protected $fillable = ['title'];
}
