<?php namespace Modules\System\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
use Modules\System\Locale;

class ModelLocaleSpecificResourceScope implements ScopeInterface
{

    protected $locale;

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    public function apply(Builder $builder, Model $model)
    {
        $locale = app()->getLocale();

        $locale = $this->locale->whereSlug($locale)->first();

        if($this->locale)
        {
            $builder->where('locale_id', $locale->getKey());
        }
    }

    public function remove(Builder $builder, Model $model)
    {

    }

}