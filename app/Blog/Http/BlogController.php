<?php namespace App\Blog\Http;

use App\Blog\Post;
use App\Blog\PostRepositoryInterface;
use App\Blog\PostTranslation;
use App\System\Http\FrontController;

class BlogController extends FrontController
{

    public function index(Post $post, PostRepositoryInterface $posts)
    {
        /**
         * images are lazyloaded in specific template file.. are they really?
         */
        $posts = Post::with($posts->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.' . $this->theme->setting('blogOverview'), ['posts' => $posts])->render();
    }

    public function show(PostTranslation $post, PostRepositoryInterface $posts)
    {
        $post = $post->post;

        $post->load($posts->relations());

        $this->seo->setEntity($post);

        $related = $posts->getRelatedPosts($post);

        return $this->theme->render('blog.' . $this->theme->setting('blogDetail'), ['post' => $post, 'related' => $related]);
    }
}