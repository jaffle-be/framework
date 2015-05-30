<?php namespace App\Blog;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model{

    use Translatable;

    protected $table = 'posts';

    protected $translatedAttributes = ['title', 'extract', 'content', 'publish_at'];

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }
}