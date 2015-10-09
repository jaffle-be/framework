<?php namespace App\Media\Files;

use App\System\Scopes\ModelAccountResource;
use App\System\Scopes\ModelAutoSort;
use App\System\Scopes\ModelLocaleSpecificResource;
use Illuminate\Database\Eloquent\Model;

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