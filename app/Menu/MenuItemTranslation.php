<?php namespace App\Menu;

use Jaffle\Tools\TranslationModel;

class MenuItemTranslation extends TranslationModel
{

    protected $table = 'menu_item_translations';

    protected $fillable = ['locale', 'menu_id', 'name'];

}