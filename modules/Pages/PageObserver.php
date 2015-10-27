<?php namespace Modules\Pages;

use Illuminate\Contracts\Auth\Guard;

class PageObserver {

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    public function creating(Page $post)
    {
        if(!$post->user_id)
        {
            $post->user()->associate($this->auth->user());
        }
    }

}