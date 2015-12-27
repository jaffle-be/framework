<?php

namespace Modules\Blog;

use Modules\Users\User;

/**
 * Class PostRepository
 * @package Modules\Blog
 */
class PostRepository implements PostRepositoryInterface
{
    protected $post;

    protected $translation;

    /**
     * @param Post $post
     * @param PostTranslation $translation
     */
    public function __construct(Post $post, PostTranslation $translation)
    {
        $this->post = $post;
        $this->translation = $translation;
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function getRelatedPosts(Post $post)
    {
        return $this->post->with($this->relations())->limit(100)->get()->shuffle()->take(3);
    }

    /**
     * @return array
     */
    public function relations()
    {
        return ['user', 'translations', 'tags', 'tags.translations'];
    }

    /**
     * @param User $author
     * @return mixed
     */
    public function getAuthorArticles(User $author)
    {
        return $this->post->with($this->relations())
            ->authoredBy($author)
            ->latest()
            ->limit(9)
            ->get();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestPosts($limit)
    {
        return $this->post
            ->with($this->relations())
            ->limit($limit)
            ->latest()
            ->get();
    }
}
