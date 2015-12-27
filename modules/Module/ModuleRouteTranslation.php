<?php

namespace Modules\Module;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ModuleRouteTranslation
 * @package Modules\Module
 */
class ModuleRouteTranslation extends TranslationModel
{
    protected $table = 'module_route_translations';

    protected $fillable = ['title'];
}
