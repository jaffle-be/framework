<?php namespace App\Blog;

interface PostRepositoryInterface
{

    public function getRelatedPosts(Post $post);

    public function getLatestPosts($limit);

    public function relations();

}