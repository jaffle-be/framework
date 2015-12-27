<?php

namespace Modules\Module;

use Modules\System\Translatable\TranslationModel;

class ModuleTranslation extends TranslationModel
{

    protected $table = 'module_translations';

    protected $fillable = ['name'];

    public function module()
    {
        return $this->belongsTo('Modules\Module\Module');
    }
}
