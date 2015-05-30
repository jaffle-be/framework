<?php namespace App\Blog;

use Illuminate\Contracts\Auth\Guard;

class PostTranslationObserver {

    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    public function creating(PostTranslation $translation)
    {
        if(!$translation->user_id)
        {
            $translation->user()->associate($this->auth->user());
        }
    }

}