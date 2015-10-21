<?php namespace App\Module;

use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ModuleRoute extends Model
{
    use Translatable;

    protected $table = "module_routes";

    protected $fillable = ["module_id", "name", "title"];

    protected $translatedAttributes = ['title'];

    public function module()
    {
        return $this->belongsTo('App\Module\Module');
    }

    public function scopeBut(Builder $builder, Collection $pages)
    {
        if($pages->count() > 0)
        {
            $builder->whereNotIn($this->getKeyName(), $pages->lists($this->getKeyName())->toArray());
        }
    }

}