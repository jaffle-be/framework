<?php namespace App\Module;

use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    use Translatable;

    protected $table = 'modules';

    protected $fillable = ['namespace', 'name'];

    protected $translatedAttributes = ['name'];

    public function routes()
    {
        return $this->hasMany('App\Module\ModuleRoute', 'module_id');
    }

    public function newCollection(array $models = [])
    {
        return new ModuleCollection($models);
    }

}