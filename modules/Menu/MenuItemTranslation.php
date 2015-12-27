<?php

namespace Modules\Menu;

use Modules\System\Translatable\TranslationModel;

/**
 * Class MenuItemTranslation
 * @package Modules\Menu
 */
class MenuItemTranslation extends TranslationModel
{
    protected $table = 'menu_item_translations';

    protected $fillable = ['locale', 'menu_id', 'name'];
}
