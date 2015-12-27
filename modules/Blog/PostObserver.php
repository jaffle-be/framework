<?php

namespace Modules\Blog;

use Illuminate\Contracts\Auth\Guard;

class PostObserver
{

    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    public function creating(Post $post)
    {
        if (!$post->user_id) {
            $post->user()->associate($this->auth->user());
        }
    }
}
