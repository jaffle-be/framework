<?php namespace App\Blog\Http;

use App\Blog\PostRepositoryInterface;
use App\Blog\PostTranslation;

trait BlogFrontControlling
{
    /**
     * @param PostTranslation         $post
     * @param PostRepositoryInterface $posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function renderPostDetail(PostTranslation $post, PostRepositoryInterface $posts)
    {
        $post = $post->post;

        $post->load($posts->relations());

        $this->seo->setEntity($post);

        $related = $posts->getRelatedPosts($post);

        return $this->theme->render('blog.detail', ['post' => $post, 'related' => $related]);
    }

}