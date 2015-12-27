<?php

namespace Modules\Blog;

use Modules\Users\User;

interface PostRepositoryInterface
{
    public function getAuthorArticles(User $author);

    public function getRelatedPosts(Post $post);

    public function getLatestPosts($limit);

    public function relations();
}
