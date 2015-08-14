<?php namespace App\Theme;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model implements StoresMedia
{
    use StoringMedia;

    protected $table = "themes";

    protected $fillable = ['name', 'version'];

    protected $media = '{acount}/theme';

    protected $mediaMultiple = false;


    /**
     * Return an asset from a theme
     *
     * @param $asset
     * @return string
     */
    public function asset($asset)
    {
        $asset = config('theme.public_path') . '/' . $this->name . '/assets/' . ltrim($asset, '/');

        return asset($asset);
    }

    public function settings()
    {
        return $this->hasMany('App\Theme\ThemeSetting', 'theme_id');
    }

    public function selection()
    {
        return $this->hasOne('App\Theme\ThemeSelection');
    }

}