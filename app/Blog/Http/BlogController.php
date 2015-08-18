<?php namespace App\Blog\Http;

use App\Blog\Post;
use App\System\Http\Controller;

class BlogController extends Controller
{

    public function index(Post $post)
    {
        /**
         * images are lazyloaded in specific template file
         */
        $posts = Post::with($this->relations())->orderBy('created_at', 'desc')->paginate();

        return $this->theme->render('blog.' . $this->theme->setting('blogOverview'), ['posts' => $posts])->render();
    }

    public function show(Post $post)
    {
        $post->load($this->relations(1140));

        $related = $post->with($this->relations(360))->get()->shuffle()->take(3);

        return $this->theme->render('blog.' . $this->theme->setting('blogDetail'), ['post' => $post, 'related' => $related]);
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['user', 'translations', 'tags', 'tags.translations'];
    }
}