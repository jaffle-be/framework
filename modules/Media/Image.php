<?php

namespace Modules\Media;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Image\ImageModelTrait;
use Modules\System\Scopes\ModelAccountOrSystemResource;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Translatable\Translatable;

/**
 * Class Image
 * @package Modules\Media
 */
class Image extends Model
{
    use Translatable;
    use ModelAccountOrSystemResource;
    use ModelAutoSort;
    use ImageModelTrait;

    protected $table = 'media_images';

    protected $fillable = ['account_id', 'path', 'filename', 'extension', 'width', 'height', 'title'];

    protected $translatedAttributes = ['title'];

    protected $hidden = ['account_id', 'filename', 'extension', 'width', 'height', 'owner_id', 'owner_type', 'created_at', 'updated_at', 'original_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
