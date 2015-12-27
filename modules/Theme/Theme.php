<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;

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
     *
     *
     * @return string
     */
    public function asset($asset)
    {
        $asset = config('theme.public_path').'/'.$this->name.'/assets/'.ltrim($asset, '/');

        return asset($asset);
    }

    public function settings()
    {
        return $this->hasMany('Modules\Theme\ThemeSetting', 'theme_id');
    }

    public function selection()
    {
        return $this->hasOne('Modules\Theme\ThemeSelection');
    }
}
