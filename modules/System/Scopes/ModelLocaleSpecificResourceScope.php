<?php

namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\System\Locale;

/**
 * Class ModelLocaleSpecificResourceScope
 * @package Modules\System\Scopes
 */
class ModelLocaleSpecificResourceScope implements Scope
{
    protected $locale;

    /**
     * @param Locale $locale
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $locale = app()->getLocale();

        $locale = $this->locale->where('slug', $locale)->first();

        if ($locale) {
            $builder->where('locale_id', $locale->getKey());
        }
    }
}
