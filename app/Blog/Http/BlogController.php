<?php namespace App\Blog\Http;

use App\Blog\Post;
use App\Blog\PostRepositoryInterface;
use App\Blog\PostTranslation;
use App\System\Http\FrontController;

class BlogController extends FrontController
{
    use BlogFrontControlling;

    public function index(Post $post, PostRepositoryInterface $posts)
    {
        /**
         * images are lazyloaded in specific template file.. are they really?
         */
        $posts = Post::with($posts->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.overview', ['posts' => $posts])->render();
    }

    public function show(PostTranslation $post, PostRepositoryInterface $posts)
    {
        //extracted for reuse in our uri controller
        return $this->renderPostDetail($post, $posts);
    }
}