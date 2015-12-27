<?php

namespace Modules\Blog\Http;

use Modules\Blog\Post;
use Modules\Blog\PostRepositoryInterface;
use Modules\System\Http\FrontController;

/**
 * Class BlogController
 * @package Modules\Blog\Http
 */
class BlogController extends FrontController
{
    use BlogFrontControlling;

    /**
     * @param Post $post
     * @param PostRepositoryInterface $posts
     * @return string
     */
    public function index(Post $post, PostRepositoryInterface $posts)
    {
        /*
         * images are lazyloaded in specific template file.. are they really?
         */
        $posts = Post::with($posts->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.overview', ['posts' => $posts])->render();
    }
}
