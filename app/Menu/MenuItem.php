<?php namespace App\Menu;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model{

    protected $table = 'menu_items';

    protected $fillable = ['name', 'menu_id', 'parent_id', 'url', 'menuable_id', 'menuable_type', 'label', 'title', 'css_class'];

    public function parent()
    {

    }

    public function menu()
    {
        return $this->belongsTo('Menu\Menu', 'menu_id');
    }

    public function children()
    {
        return $this->hasMany('App\Menu\Menuitem', 'parent_id');
    }

    public function item()
    {
        return $this->morphTo();
    }

}