<?php namespace Modules\Theme;

use Illuminate\Database\Eloquent\Collection;

class ThemeSettingCollection extends Collection
{

    public function byModule()
    {
        return $this->groupBy(function ($item) {
            //for now, we set up the module to be the first camelcame part of the key itself
            $pieces = explode('_', snake_case($item->key));

            return array_shift($pieces);
        });
    }

}