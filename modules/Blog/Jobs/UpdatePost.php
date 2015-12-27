<?php

namespace Modules\Blog\Jobs;

use App\Jobs\Job;
use Modules\Blog\Post;

/**
 * Class UpdatePost
 * @package Modules\Blog\Jobs
 */
class UpdatePost extends Job
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Post $post
     * @param array $input
     */
    public function __construct(Post $post, array $input)
    {
        $this->post = $post;
        $this->input = $input;
    }

    /**
     * @return bool|Post
     */
    public function handle()
    {
        $this->post->fill($this->input);

        return $this->post->save() ? $this->post : false;
    }
}
