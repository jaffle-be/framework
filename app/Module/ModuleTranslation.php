<?php namespace App\Module;

use App\System\Translatable\TranslationModel;

class ModuleTranslation extends TranslationModel
{

    protected $table = "module_translations";

    protected $fillable = ['name'];

    public function module()
    {
        return $this->belongsTo('App\Module\Module');
    }

}