<?php namespace App\Menu;

use App\System\Presenter\PresentableEntity;
use App\System\Presenter\PresentableTrait;
use App\System\Scopes\ModelAutoSort;
use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model implements PresentableEntity{

    use Translatable;
    use ModelAutoSort;
    use PresentableTrait;

    protected $table = 'menu_items';

    protected $translatedAttributes = ['name'];

    protected $fillable = ['name', 'menu_id', 'parent_id', 'url', 'target_blank', 'page_id', 'module_route_id'];

    protected $presenter = 'App\Menu\Presenter\MenuItemFrontPresenter';

    protected $casts = [
        'target_blank' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Menu\MenuItem');
    }

    public function menu()
    {
        return $this->belongsTo('Menu\Menu', 'menu_id');
    }

    public function children()
    {
        return $this->hasMany('App\Menu\MenuItem', 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Pages\Page');
    }

    public function route()
    {
        return $this->belongsTo('App\Module\ModuleRoute', 'module_route_id');
    }

    public function getTargetAttribute()
    {
        return $this->attributes['target_blank'] ? '_blank': null;
    }

}