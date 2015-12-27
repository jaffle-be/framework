<?php

namespace Modules\System\Seo;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelLocaleSpecificResource;
use Modules\System\Translatable\TranslationCollection;

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
        return $this->belongsTo('Modules\System\Locale');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $items = [])
    {
        return new TranslationCollection($items);
    }
}
