<?php

namespace Modules\Module;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Module extends Model
{

    use Translatable;

    protected $table = 'modules';

    protected $fillable = ['namespace', 'name'];

    protected $translatedAttributes = ['name'];

    public function routes()
    {
        return $this->hasMany('Modules\Module\ModuleRoute', 'module_id');
    }

    public function newCollection(array $models = [])
    {
        return new ModuleCollection($models);
    }
}
