<?php namespace App\Menu;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model{

    protected $table = 'system_menu_items';

    protected $fillable = ['name', 'menu_id', 'menuable_id', 'menuable_type', 'label', 'title', 'css_class'];

    public function menu()
    {
        return $this->belongsTo('Menu\Menu', 'menu_id');
    }

    public function item()
    {
        return $this->morphTo();
    }

}