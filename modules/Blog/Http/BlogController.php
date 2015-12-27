<?php

namespace Modules\Blog\Http;

use Modules\Blog\Post;
use Modules\Blog\PostRepositoryInterface;
use Modules\System\Http\FrontController;

class BlogController extends FrontController
{

    use BlogFrontControlling;

    public function index(Post $post, PostRepositoryInterface $posts)
    {
        /*
         * images are lazyloaded in specific template file.. are they really?
         */
        $posts = Post::with($posts->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.overview', ['posts' => $posts])->render();
    }
}
