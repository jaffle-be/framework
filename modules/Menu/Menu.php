<?php

namespace Modules\Menu;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class Menu
 * @package Modules\Menu
 */
class Menu extends Model
{
    use ModelAccountResource;

    protected $table = 'menus';

    protected $fillable = ['account_id', 'name'];

    /**
     * @return mixed
     */
    public function items()
    {
        return $this->hasMany('Modules\Menu\MenuItem', 'menu_id')->whereNull('parent_id');
    }
}
