<?php namespace Modules\Media\Files;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Scopes\ModelLocaleSpecificResource;

class File extends Model
{
    use ModelAccountResource;
    use ModelAutoSort;
    use ModelLocaleSpecificResource;

    protected $table = 'media_files';

    protected $fillable = ['account_id', 'locale_id', 'path', 'filename', 'extension', 'title'];

    public function owner()
    {
        return $this->morphTo();
    }

}