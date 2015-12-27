<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;

/**
 * Class Theme
 * @package Modules\Theme
 */
class Theme extends Model implements StoresMedia
{
    use StoringMedia;

    protected $table = 'themes';

    protected $fillable = ['name', 'version'];

    protected $media = '{acount}/theme';

    protected $mediaMultiple = false;

    /**
     * Return an asset from a theme.
     *
     * @param $asset
     * @return string
     */
    public function asset($asset)
    {
        $asset = config('theme.public_path').'/'.$this->name.'/assets/'.ltrim($asset, '/');

        return asset($asset);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany('Modules\Theme\ThemeSetting', 'theme_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function selection()
    {
        return $this->hasOne('Modules\Theme\ThemeSelection');
    }
}
