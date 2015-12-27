<?php

namespace Modules\Menu;

use Modules\System\Translatable\TranslationModel;

class MenuItemTranslation extends TranslationModel
{
    protected $table = 'menu_item_translations';

    protected $fillable = ['locale', 'menu_id', 'name'];
}
