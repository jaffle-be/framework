<?php

namespace Modules\Blog;

use Illuminate\Contracts\Auth\Guard;

/**
 * Class PostObserver
 * @package Modules\Blog
 */
class PostObserver
{
    /**
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    /**
     * @param Post $post
     */
    public function creating(Post $post)
    {
        if (! $post->user_id) {
            $post->user()->associate($this->auth->user());
        }
    }
}
