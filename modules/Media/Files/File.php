<?php

namespace Modules\Media\Files;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Scopes\ModelLocaleSpecificResource;

/**
 * Class File
 * @package Modules\Media\Files
 */
class File extends Model
{
    use ModelAccountResource;
    use ModelAutoSort;
    use ModelLocaleSpecificResource;

    protected $table = 'media_files';

    protected $fillable = ['account_id', 'locale_id', 'path', 'filename', 'extension', 'title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
