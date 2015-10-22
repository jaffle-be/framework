<?php namespace App\System\Seo;

use App\System\Scopes\ModelLocaleSpecificResource;
use App\System\Translatable\TranslationCollection;
use Illuminate\Database\Eloquent\Model;

class SeoProperty extends Model
{
    use ModelLocaleSpecificResource;

    protected $table = 'seo_properties';

    protected $fillable = ['owner_type', 'owner_id', 'locale_id', 'title', 'description', 'keywords'];


    public function owner()
    {
        return $this->morphTo();
    }

    public function locale()
    {
        return $this->belongsTo('App\System\Locale');
    }

    public function newCollection(array $items = [])
    {
        return new TranslationCollection($items);
    }

}