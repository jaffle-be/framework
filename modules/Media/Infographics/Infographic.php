<?php

namespace Modules\Media\Infographics;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Image\ImageModelTrait;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Scopes\ModelLocaleSpecificResource;

/**
 * Class Infographic
 * @package Modules\Media\Infographics
 */
class Infographic extends Model
{
    use ModelAccountResource;
    use ModelAutoSort;
    use ModelLocaleSpecificResource;
    use ImageModelTrait;

    protected $table = 'media_infographics';

    protected $fillable = ['account_id', 'locale_id', 'path', 'filename', 'extension', 'width', 'height', 'title'];

    protected $hidden = ['account_id', 'locale_id', 'filename', 'extension', 'width', 'height', 'owner_id', 'owner_type', 'created_at', 'updated_at', 'original_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
