<?php namespace App\Blog;

use Jaffle\Tools\TranslationModel;

class PostTranslation extends TranslationModel{

    protected $table = 'post_translations';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

}