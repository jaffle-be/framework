<?php

namespace Modules\System\Seo;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelLocaleSpecificResource;
use Modules\System\Translatable\TranslationCollection;

/**
 * Class SeoProperty
 * @package Modules\System\Seo
 */
class SeoProperty extends Model
{
    use ModelLocaleSpecificResource;

    protected $table = 'seo_properties';

    protected $fillable = ['owner_type', 'owner_id', 'locale_id', 'title', 'description', 'keywords'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locale()
    {
        return $this->belongsTo('Modules\System\Locale');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection
     * @internal param array $models
     */
    public function newCollection(array $items = [])
    {
        return new TranslationCollection($items);
    }
}
