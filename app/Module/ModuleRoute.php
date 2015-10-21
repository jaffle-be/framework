<?php namespace App\Module;

use Illuminate\Database\Eloquent\Model;

class ModuleRoute extends Model
{

    protected $table = "module_routes";

    protected $fillable = ["module_id", "name"];

    public function module()
    {
        return $this->belongsTo('App\Module\Module');
    }

}