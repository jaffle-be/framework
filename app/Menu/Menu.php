<?php namespace App\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{

    protected $table = 'system_menu';

    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany('App\Menu\MenuItem', 'menu_id');
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