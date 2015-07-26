<?php namespace App\Tags;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{

    use Translatable;

    protected $table = "tags";

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

    public function posts()
    {
        return $this->morphedByMany('App\Blog\Post', 'taggable');
    }

    public function content()
    {
        return $this->hasMany('App\Tags\TaggedContent');
    }

}