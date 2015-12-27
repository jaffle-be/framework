<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class ThemeSettingValue
 * @package Modules\Theme
 */
class ThemeSettingValue extends Model
{
    use ModelAccountResource;
    use \Modules\System\Translatable\Translatable;

    protected $table = 'themes_setting_values';

    protected $fillable = ['selection_id', 'key_id', 'account_id', 'option_id', 'value', 'string', 'text'];

    protected $translatedAttributes = ['string', 'text'];

    protected $translationForeignKey = 'value_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function selection()
    {
        return $this->belongsTo('Modules\Theme\ThemeSelection', 'selection_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo('Modules\Theme\ThemeSettingOption', 'option_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo('Modules\Theme\ThemeSetting', 'key_id');
    }
}
