<?php

namespace Modules\Menu;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Translatable\Translatable;

class MenuItem extends Model implements PresentableEntity
{
    use Translatable;
    use ModelAutoSort;
    use PresentableTrait;

    protected $table = 'menu_items';

    protected $translatedAttributes = ['name'];

    protected $fillable = ['name', 'menu_id', 'parent_id', 'url', 'target_blank', 'page_id', 'module_route_id'];

    protected $presenter = 'Modules\Menu\Presenter\MenuItemFrontPresenter';

    protected $casts = [
        'target_blank' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo('Modules\Menu\MenuItem');
    }

    public function menu()
    {
        return $this->belongsTo('Menu\Menu', 'menu_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Menu\MenuItem', 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo('Modules\Pages\Page');
    }

    public function route()
    {
        return $this->belongsTo('Modules\Module\ModuleRoute', 'module_route_id');
    }

    public function getTargetAttribute()
    {
        return $this->attributes['target_blank'] ? '_blank' : null;
    }
}
