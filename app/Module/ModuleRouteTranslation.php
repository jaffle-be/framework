<?php namespace App\Module;

use App\System\Translatable\TranslationModel;

class ModuleRouteTranslation extends TranslationModel
{

    protected $table = 'module_route_translations';

    protected $fillable = ['title'];

}