<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class ThemeSelection
 * @package Modules\Theme
 */
class ThemeSelection extends Model
{
    use ModelAccountResource;

    protected $table = 'themes_selections';

    protected $fillable = ['theme_id', 'account_id', 'active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo('Modules\Theme\Theme');
    }
}
