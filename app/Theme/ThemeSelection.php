<?php namespace App\Theme;

use App\System\Scopes\ModelAccountResource;
use Illuminate\Database\Eloquent\Model;

class ThemeSelection extends Model
{
    use ModelAccountResource;

    protected $table = 'themes_selections';

    protected $fillable = ['theme_id', 'account_id', 'active'];

    public function theme()
    {
        return $this->belongsTo('App\Theme\Theme');
    }

}