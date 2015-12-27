<?php

namespace Modules\Module;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

/**
 * Class Module
 * @package Modules\Module
 */
class Module extends Model
{
    use Translatable;

    protected $table = 'modules';

    protected $fillable = ['namespace', 'name'];

    protected $translatedAttributes = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function routes()
    {
        return $this->hasMany('Modules\Module\ModuleRoute', 'module_id');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ModuleCollection($models);
    }
}
