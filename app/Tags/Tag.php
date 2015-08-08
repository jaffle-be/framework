<?php namespace App\Tags;

use App\System\Scopes\ModelAccountResource;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{

    use Translatable;
    use ModelAccountResource;

    protected $table = "tags";

    protected $fillable = ['account_id', 'name'];

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