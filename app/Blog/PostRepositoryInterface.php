<?php namespace App\Blog;

use App\Users\User;

interface PostRepositoryInterface
{
    public function getAuthorArticles(User $author);

    public function getRelatedPosts(Post $post);

    public function getLatestPosts($limit);

    public function relations();

}