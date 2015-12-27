<?php

namespace Modules\Blog\Jobs;

use App\Jobs\Job;
use Modules\Blog\Post;

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

    public function __construct(Post $post, array $input)
    {
        $this->post = $post;
        $this->input = $input;
    }

    public function handle()
    {
        $this->post->fill($this->input);

        return $this->post->save() ? $this->post : false;
    }
}
