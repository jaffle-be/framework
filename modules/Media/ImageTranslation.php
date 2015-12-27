<?php

namespace Modules\Media;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ImageTranslation
 * @package Modules\Media
 */
class ImageTranslation extends TranslationModel
{
    protected $table = 'media_image_translations';

    protected $fillable = ['title'];
}
