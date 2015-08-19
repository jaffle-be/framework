<?php namespace App\Menu;

use App\System\Translatable\TranslationModel;

class MenuItemTranslation extends TranslationModel
{

    protected $table = 'menu_item_translations';

    protected $fillable = ['locale', 'menu_id', 'name'];

}