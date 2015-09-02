<?php namespace App\Blog;

class PostRepository implements PostRepositoryInterface
{

    protected $post;

    protected $translation;

    public function __construct(Post $post, PostTranslation $translation)
    {
        $this->post = $post;
        $this->translation = $translation;
    }

    public function getRelatedPosts(Post $post)
    {
        return $this->post->with($this->relations())->limit(100)->get()->shuffle()->take(3);
    }

    public function getLatestPosts($limit)
    {
        return $this->post
            ->with($this->relations())
            ->limit($limit)
            ->latest()
            ->get(['posts.*']);
    }

    public function relations()
    {
        return ['user', 'translations', 'tags', 'tags.translations'];
    }

}