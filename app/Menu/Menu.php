<?php namespace App\Menu;

use App\System\Scopes\ModelAccountResource;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model{

    use ModelAccountResource;

    protected $table = 'menus';

    protected $fillable = ['account_id', 'name'];

    public function items()
    {
        return $this->hasMany('App\Menu\MenuItem', 'menu_id')->whereNull('parent_id');
    }

    public function scopeSupported($query, array $supported)
    {
        if(empty($supported))
        {
            $query->whereNull($this->getKeyName());
        }
        else
        {
            $query->whereIn('name', $supported);
        }
    }
}