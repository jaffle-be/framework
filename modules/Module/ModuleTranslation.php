<?php

namespace Modules\Module;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ModuleTranslation
 * @package Modules\Module
 */
class ModuleTranslation extends TranslationModel
{
    protected $table = 'module_translations';

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo('Modules\Module\Module');
    }
}
