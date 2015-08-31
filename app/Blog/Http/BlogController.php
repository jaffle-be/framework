<?php namespace App\Blog\Http;

use App\Blog\Post;
use App\Blog\PostRepositoryInterface;
use App\System\Http\Controller;

class BlogController extends Controller
{

    public function index(Post $post, PostRepositoryInterface $posts)
    {
        /**
         * images are lazyloaded in specific template file
         */
        $posts = Post::with($posts->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.' . $this->theme->setting('blogOverview'), ['posts' => $posts])->render();
    }

    public function show(Post $post, PostRepositoryInterface $posts)
    {
        $post->load($posts->relations());

        $related = $posts->getRelatedPosts($post);

        return $this->theme->render('blog.' . $this->theme->setting('blogDetail'), ['post' => $post, 'related' => $related]);
    }
}