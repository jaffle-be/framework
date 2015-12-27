<?php

namespace Modules\Blog;

use Modules\Users\User;

/**
 * Interface PostRepositoryInterface
 * @package Modules\Blog
 */
interface PostRepositoryInterface
{
    /**
     * @param User $author
     * @return mixed
     */
    public function getAuthorArticles(User $author);

    /**
     * @param Post $post
     * @return mixed
     */
    public function getRelatedPosts(Post $post);

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestPosts($limit);

    public function relations();
}
