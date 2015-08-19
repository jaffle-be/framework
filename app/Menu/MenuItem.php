<?php namespace App\Menu;

use App\System\Scopes\ModelAutoSort;
use Jaffle\Tools\Translatable;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model{

    use Translatable;
    use ModelAutoSort;

    protected $table = 'menu_items';

    protected $translatedAttributes = ['name'];

    protected $fillable = ['name', 'menu_id', 'parent_id', 'url', 'target_blank', 'menuable_id', 'menuable_type'];

    protected $casts = [
        'target_blank' => 'boolean',
    ];

    public function parent()
    {

    }

    public function menu()
    {
        return $this->belongsTo('Menu\Menu', 'menu_id');
    }

    public function children()
    {
        return $this->hasMany('App\Menu\MenuItem', 'parent_id');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function getTargetAttribute()
    {
        return $this->attributes['target_blank'] ? '_blank': null;
    }

}