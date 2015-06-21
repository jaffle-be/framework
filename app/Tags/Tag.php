<?php namespace App\Tags;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{

    use Translatable;

    protected $table = "tags";

    protected $translatedAttributes = ['name'];

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->morphedByMany('App\Blog\Post', 'taggable');
    }

}