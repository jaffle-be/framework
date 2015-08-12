<?php namespace App\Blog;

use Jaffle\Tools\TranslationModel;

class PostTranslation extends TranslationModel{

    protected $table = 'post_translations';

    protected $fillable = ['title', 'extract', 'content', 'publish_at'];

    protected $dates = ['publish_at'];

    public function user()
    {
        return $this->belongsTo('App\Users\User');
    }

    public function scopeLastPublished($query, $locale = null)
    {
        if(empty($locale))
        {
            $locale = app()->getLocale();
        }

        $query->where('locale', $locale)->orderBy('publish_at');
    }
}