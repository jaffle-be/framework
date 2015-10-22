<?php namespace App\Media\Infographics;

use App\Media\Image\ImageModelTrait;
use App\System\Scopes\ModelAccountResource;
use App\System\Scopes\ModelAutoSort;
use App\System\Scopes\ModelLocaleSpecificResource;
use Illuminate\Database\Eloquent\Model;

class Infographic extends Model
{
    use ModelAccountResource;
    use ModelAutoSort;
    use ModelLocaleSpecificResource;
    use ImageModelTrait;

    protected $table = 'media_infographics';

    protected $fillable = ['account_id', 'locale_id', 'path', 'filename', 'extension', 'width', 'height', 'title'];

    protected $hidden = ['account_id', 'locale_id', 'filename', 'extension', 'width', 'height', 'owner_id', 'owner_type', 'created_at', 'updated_at', 'original_id'];

    public function owner()
    {
        return $this->morphTo();
    }

}