<?php namespace App\Blog\Jobs;

use App\Blog\Post;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdatePost extends Job implements SelfHandling{

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